<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Mutation;

use Adeira\Connector\Devices\Application\Service\WeatherStation\Command;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStationRecord;
use Adeira\Connector\Devices\DomainModel\Humidity;
use Adeira\Connector\Devices\DomainModel\PhysicalQuantities;
use Adeira\Connector\Devices\DomainModel\Pressure;
use Adeira\Connector\Devices\DomainModel\Temperature;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecordId;
use Adeira\Connector\Devices\DomainModel\Wind;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Input\PhysicalQuantitiesInput;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationRecordType;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Structure\Argument;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;
use function Adeira\Connector\GraphQL\{
	id, type
};
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\ObjectType;

final class CreateWeatherStationRecord extends \Adeira\Connector\GraphQL\Structure\Mutation
{

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationRecordType
	 */
	private $recordType;

	/**
	 * @var \Adeira\Connector\ServiceBus\DomainModel\ICommandBus
	 */
	private $commandBus;

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Input\PhysicalQuantitiesInput
	 */
	private $input;

	/**
	 * @var \Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStationRecord
	 */
	private $singleRecord;

	public function __construct(
		WeatherStationRecordType $recordType,
		ICommandBus $commandBus,
		PhysicalQuantitiesInput $input,
		ViewSingleWeatherStationRecord $singleRecord
	) {
		$this->recordType = $recordType;
		$this->commandBus = $commandBus;
		$this->input = $input;
		$this->singleRecord = $singleRecord;
	}

	public function getPublicQueryName(): string
	{
		return 'createWeatherStationRecord';
	}

	public function getPublicQueryDescription(): string
	{
		return 'Create new record for the weather station.';
	}

	public function getQueryReturnType(): ObjectType
	{
		return type($this->recordType);
	}

	public function defineArguments(): ?array
	{
		return [
			new Argument('id', 'ID of the weather station', id()),
			new Argument('quantities', 'Physical quantities', \GraphQL\Type\Definition\Type::nonNull(
				new InputObjectType($this->input->buildStructure())
			)),
		];
	}

	public function resolve($ancestorValue, $args, Context $context)
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
			WeatherStationId::createFromString($args['id']),
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
			$wsrId
		);
	}

}
