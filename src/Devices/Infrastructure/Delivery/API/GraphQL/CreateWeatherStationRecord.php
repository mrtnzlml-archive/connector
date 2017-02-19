<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\Application\Service\WeatherStation\Command;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStationRecord;
use Adeira\Connector\Devices\DomainModel\Humidity;
use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;
use Adeira\Connector\Devices\DomainModel\Pressure;
use Adeira\Connector\Devices\DomainModel\Temperature;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecordId;
use Adeira\Connector\Devices\DomainModel\Wind;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;

final class CreateWeatherStationRecord
{

	/**
	 * @var \Adeira\Connector\ServiceBus\DomainModel\ICommandBus
	 */
	private $commandBus;

	/**
	 * @var \Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStationRecord
	 */
	private $singleRecord;

	public function __construct(
		ICommandBus $commandBus,
		ViewSingleWeatherStationRecord $singleRecord
	) {
		$this->commandBus = $commandBus;
		$this->singleRecord = $singleRecord;
	}

	public function __invoke($ancestorValue, $args, Context $context)
	{
		$quantities = $args['quantities'];

		$absolutePressure = $quantities['absolutePressure'];
		$relativePressure = $quantities['relativePressure'];
		$pressureUnit = $quantities['pressureUnit'];

		$indoorTemperature = $quantities['indoorTemperature'];
		$outdoorTemperature = $quantities['outdoorTemperature'];
		$temperatureUnit = $quantities['temperatureUnit'];

		$indoorHumidity = $quantities['indoorHumidity'];
		$outdoorHumidity = $quantities['outdoorHumidity'];
		$humidityUnit = $quantities['humidityUnit'];

		$windSpeed = $quantities['windSpeed'];
		$windAzimuth = $quantities['windAzimuth'];
		$windGust = $quantities['windGust'];
		$windSpeedUnit = $quantities['windSpeedUnit'];

		$wsrId = WeatherStationRecordId::create();
		$this->commandBus->dispatch(new Command\CreateWeatherStationRecord(
			$wsrId,
			$wsId = WeatherStationId::createFromString($args['id']),
			$context->userId(),
			new PhysicalQuantities(
				new Pressure(
					new $pressureUnit($absolutePressure),
					new $pressureUnit($relativePressure)
				),
				new Temperature(
					new $temperatureUnit($indoorTemperature),
					new $temperatureUnit($outdoorTemperature)
				),
				new Humidity(
					new $humidityUnit($indoorHumidity),
					new $humidityUnit($outdoorHumidity)
				),
				new Wind(
					new $windSpeedUnit($windSpeed),
					$windAzimuth,
					new $windSpeedUnit($windGust)
				)
			)
		));

		return $this->singleRecord->execute(
			$context->userId(),
			$wsId,
			$wsrId
		);
	}

}
