<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\Humidity;
use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;
use Adeira\Connector\Devices\DomainModel\Pressure;
use Adeira\Connector\Devices\DomainModel\Temperature;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStationId,
	WeatherStationRecord,
	WeatherStationRecordId
};
use Adeira\Connector\Devices\DomainModel\Wind;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\Pascal;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class WeatherStationRecordTest extends \Adeira\Connector\Tests\TestCase
{

	/** @var WeatherStationRecord */
	private $record;

	public function setUp()
	{
		$this->record = new WeatherStationRecord(
			WeatherStationRecordId::create(Uuid::fromString('71f3f015-1cd3-4b98-ac65-f34c1c661d39')),
			WeatherStationId::create(Uuid::fromString('846b5741-abfe-45ba-8d9e-d5a78dbe254f')),
			new PhysicalQuantities(
				new Pressure(new Pascal(101325), new Pascal(0)), //sea level standard atmospheric pressure
				new Temperature(NULL, NULL),
				new Humidity(NULL, NULL),
				new Wind(NULL, NULL, NULL)
			)
		);
	}

	public function testThatItIsPossibleToGetAllRequiredAttributes()
	{
		Assert::type(WeatherStationRecordId::class, $this->record->id());
		Assert::same('71f3f015-1cd3-4b98-ac65-f34c1c661d39', (string)$this->record->id());

		Assert::type(WeatherStationId::class, $this->record->weatherStationId());
		Assert::same('846b5741-abfe-45ba-8d9e-d5a78dbe254f', (string)$this->record->weatherStationId());
	}

	public function testPressure()
	{
		$returnedPressure = $this->record->pressure();
		Assert::type(Pressure::class, $returnedPressure);
		Assert::same(101325.0, $returnedPressure->absolute());
		Assert::same(0.0, $returnedPressure->relative());
	}

	public function testTemperature()
	{
		$returnedTemperature = $this->record->temperature();
		Assert::type(Temperature::class, $returnedTemperature);
		Assert::null($returnedTemperature->indoor());
		Assert::null($returnedTemperature->outdoor());
	}

}

(new WeatherStationRecordTest)->run();
