<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Inbound\DomainModel\DataSource;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSource;
use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class DataSourceTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		$dataSource = new DataSource(
			DataSourceId::create(Uuid::fromString('58d200ad-6376-4c01-9b6d-2ea536f1cd2c')),
			'Device Name'
		);

		Assert::type(DataSourceId::class, $dataSource->id());
		Assert::same('58d200ad-6376-4c01-9b6d-2ea536f1cd2c', (string)$dataSource->id());
		Assert::same('Device Name', $dataSource->deviceName());
	}

}

(new DataSourceTest)->run();
