<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Inbound\DomainModel\DataSourceRecord;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecord;
use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecordId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class DataSourceRecordTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		$record = new DataSourceRecord(
			DataSourceRecordId::create(Uuid::fromString('71f3f015-1cd3-4b98-ac65-f34c1c661d39')),
			DataSourceId::create(Uuid::fromString('846b5741-abfe-45ba-8d9e-d5a78dbe254f')),
			[
				'data_1',
				'data_2',
			]
		);

		Assert::type(DataSourceRecordId::class, $record->id());
		Assert::same('71f3f015-1cd3-4b98-ac65-f34c1c661d39', (string)$record->id());

		Assert::type(DataSourceId::class, $record->dataSourceId());
		Assert::same('846b5741-abfe-45ba-8d9e-d5a78dbe254f', (string)$record->dataSourceId());

		Assert::same([
			'data_1',
			'data_2',
		], $record->data());
	}

}

(new DataSourceRecordTest)->run();
