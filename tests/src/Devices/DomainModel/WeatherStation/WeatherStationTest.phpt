<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\{
	User,
	UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStation,
	WeatherStationId
};
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class WeatherStationTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		$dataSource = new WeatherStation(
			WeatherStationId::create(Uuid::fromString('58d200ad-6376-4c01-9b6d-2ea536f1cd2c')),
			new User(UserId::create(), 'User Name'),
			'Device Name'
		);

		Assert::type(WeatherStationId::class, $dataSource->id());
		Assert::same('58d200ad-6376-4c01-9b6d-2ea536f1cd2c', (string)$dataSource->id());
		Assert::same('Device Name', $dataSource->deviceName());
	}

}

(new WeatherStationTest)->run();
