<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Inbound\DomainModel\DataSourceRecord;

use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecordId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class DataSourceRecordIdTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatConstructorIsPrivate()
	{
		Assert::exception(function () {
			new DataSourceRecordId;
		}, \Error::class, 'Call to private ' . DataSourceRecordId::class . '::__construct() from context%a%');
	}

	public function testThatSameValuesAreEqual()
	{
		$id1 = DataSourceRecordId::create($uuid = Uuid::uuid4());
		$id2 = DataSourceRecordId::create($uuid);
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

	public function testThatDifferentValuesAreNotEqual()
	{
		$id1 = DataSourceRecordId::create(Uuid::uuid4());
		$id2 = DataSourceRecordId::create(Uuid::uuid4());
		Assert::notSame($id1, $id2);
		Assert::false($id1->equals($id2));
		Assert::false($id2->equals($id1));
	}

}

(new DataSourceRecordIdTest)->run();
