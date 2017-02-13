<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Authentication\DomainModel\Owner;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class OwnerTest extends \Tester\TestCase
{

	public function testThatOwnerDoesNotMutateUser()
	{
		$user = new User(UserId::createFromString('11111111-2222-3333-4444-555555555555'), 'jůzrnějm');
		$owner = new Owner($user);

		Assert::notSame($user->id(), $owner->id()); // UUIDs are not the same, but values are
		Assert::same((string)$user->id(), (string)$owner->id());
		Assert::same('11111111-2222-3333-4444-555555555555', (string)$owner->id());

		Assert::same($user->nickname(), $owner->nickname());
		Assert::same('jůzrnějm', $owner->nickname());
	}

	public function testThatCloneGeneratesNewUUID()
	{
		$user = new User(UserId::createFromString($originalUuidString = '11111111-2222-3333-4444-555555555555'), 'jůzrnějm');
		$owner = new Owner($user);

		Assert::notSame($owner, $newOwner = clone $owner);
		Assert::type(UserId::class, $newOwner->id());
		Assert::notSame($originalUuidString, (string)$newOwner->id());
	}

}

(new OwnerTest)->run();
