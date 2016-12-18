<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Identity\DomainModel\User;

use Adeira\Connector\Identity\DomainModel\User\NullUserId;
use Adeira\Connector\Identity\DomainModel\User\UserId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class NullUserIdTest extends \Tester\TestCase
{

	public function testThatConstructorIsPrivate()
	{
		Assert::exception(function () {
			new NullUserId;
		}, \Error::class, 'Call to private ' . UserId::class . '::__construct() from context%a%');
	}

	public function testThatSameValuesAreEqual()
	{
		$id1 = NullUserId::create($uuid = Uuid::uuid4());
		$id2 = NullUserId::create($uuid);
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

	public function testThatDifferentValuesAreEqualBecauseOfNull()
	{
		$id1 = NullUserId::create(Uuid::uuid4());
		$id2 = NullUserId::create(Uuid::uuid4());
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

	public function testThatItCreatesNullValue()
	{
		Assert::same('00000000-0000-0000-0000-000000000000', (string)NullUserId::create());
		Assert::same('00000000-0000-0000-0000-000000000000', (string)NullUserId::create(Uuid::uuid4()));
		Assert::same('00000000-0000-0000-0000-000000000000', (string)NullUserId::createFromString(Uuid::uuid4()->toString()));
	}

}

(new NullUserIdTest)->run();
