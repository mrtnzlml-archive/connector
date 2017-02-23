<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Authentication\Infrastructure\Persistence\InMemory;

use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class InMemoryUserRepositoryTest extends \Tester\TestCase
{

	public function testThatOfIdWorks()
	{
		$repository = new InMemoryUserRepository;
		$wid = UserId::createFromString('00000000-0000-0000-0000-000000000001');
		Assert::null($repository->ofId($wid));

		$repository->add($user = new User($wid, 'User Name'));
		Assert::same($user, $repository->ofId($wid));
	}

	public function testThatOfUsernameWorks()
	{
		$repository = new InMemoryUserRepository;
		Assert::null($repository->ofUsername('User Name'));

		$repository->add($user = new User(UserId::create(), 'User Name'));
		Assert::same($user, $repository->ofUsername('User Name'));
	}

	public function testThatNextIdentityWorks()
	{
		$repository = new InMemoryUserRepository;
		$id = $repository->nextIdentity();
		Assert::type(UserId::class, $id);
		Assert::type('string', $id->toString());
	}

}

(new InMemoryUserRepositoryTest)->run();
