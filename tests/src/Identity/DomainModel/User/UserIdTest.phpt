<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Identity\DomainModel\User;

use Adeira\Connector\Identity\DomainModel\User\UserId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class UserIdTest extends \Tester\TestCase
{

	public function testThatConstructorIsPrivate()
	{
		Assert::exception(function () {
			new UserId;
		}, \Error::class, 'Call to private ' . UserId::class . '::__construct() from context%a%');
	}

	public function testThatSameValuesAreEqual()
	{
		$id1 = UserId::create($uuid = Uuid::uuid4());
		$id2 = UserId::create($uuid);
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

	public function testThatDifferentValuesAreNotEqual()
	{
		$id1 = UserId::create(Uuid::uuid4());
		$id2 = UserId::create(Uuid::uuid4());
		Assert::notSame($id1, $id2);
		Assert::false($id1->equals($id2));
		Assert::false($id2->equals($id1));
	}

	public function testThatCreateFormStringWorks()
	{
		$uuid = UserId::createFromString($originalString = '10000000-2000-3000-4000-500000000000');
		Assert::type(UserId::class, $uuid);
		Assert::same($originalString, (string)$uuid);
	}

}

(new UserIdTest)->run();
