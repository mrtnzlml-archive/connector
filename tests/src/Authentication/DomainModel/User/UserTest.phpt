<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Authentication\DomainModel\User;

use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class UserTest extends \Tester\TestCase
{

	public function testThatBasicConstructWorks()
	{
		$user = new User(UserId::createFromString('11111111-2222-3333-4444-555555555555'), 'jůzrnějm');
		Assert::type(UserId::class, $user->id());
		Assert::same('11111111-2222-3333-4444-555555555555', (string)$user->id());
		Assert::same('jůzrnějm', $user->nickname());
		Assert::null($user->token());
	}

	public function testThatNetteSecurityIIdentityIsImplemented()
	{
		$user = new User(UserId::createFromString('11111111-2222-3333-4444-555555555555'), 'jůzrnějm');
		Assert::same($user->id(), $user->getId());
		Assert::same([], $user->getRoles());
	}

	public function testThatCloneGeneratesNewUUID()
	{
		$user = new User(UserId::createFromString($originalUuidString = '11111111-2222-3333-4444-555555555555'), 'jůzrnějm');
		Assert::notSame($user, $newUser = clone $user);
		Assert::type(UserId::class, $newUser->id());
		Assert::notSame($originalUuidString, (string)$newUser->id());
	}

	public function testThatAuthenticateMethodWorks()
	{
		$user = new User(UserId::createFromString($originalUuidString = '11111111-2222-3333-4444-555555555555'), 'jůzrnějm');
		Assert::null($user->token());
		$user->authenticate('pa55w0rd', function ($newPass, $oldPass) {
			Assert::same('pa55w0rd', $newPass); //check hash
			Assert::null($oldPass);
			return TRUE;
		}, function () {
			return 'newToken'; //generate token
		});
		Assert::same('newToken', $user->token());
	}

	public function testThatChangePasswordWorks()
	{
		$user = new User(UserId::createFromString($originalUuidString = '11111111-2222-3333-4444-555555555555'), 'jůzrnějm');
		$user->needRehash(function ($password) {
			Assert::null($password);
			return TRUE;
		});
		$user->changePass('pa55w0rd', function ($password) {
			return mb_strtoupper($password); //hash function
		});
		$user->needRehash(function ($password) {
			Assert::same('PA55W0RD', $password);
			return TRUE;
		});
	}

}

(new UserTest)->run();
