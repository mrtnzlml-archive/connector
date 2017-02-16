<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Input;

use Adeira\Connector\GraphQL\Type\InputValue;
use Adeira\Connector\PhysicalUnits\DomainModel\Humidity\Units\Percentage;
use Adeira\Connector\PhysicalUnits\DomainModel\Pressure\Units\{
	Atm, Bar, Pascal, Torr
};
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Kmh;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Mph;
use Adeira\Connector\PhysicalUnits\DomainModel\Speed\Units\Ms;
use Adeira\Connector\PhysicalUnits\DomainModel\Temperature\Units\{
	Celsius, Fahrenheit, Kelvin
};
use function Adeira\Connector\GraphQL\nullableFloat;
use GraphQL\Type\Definition\EnumType;

final class PhysicalQuantitiesInput extends \Adeira\Connector\GraphQL\Type\InputObject
{

	public function publicName(): string
	{
		return 'PhysicalQuantitiesInput';
	}

	public function fields(): array
	{
		return [
			new InputValue('absolutePressure', nullableFloat()),
			new InputValue('relativePressure', nullableFloat()),
			new InputValue('pressureUnit', new EnumType([ //TODO: move to the separate class
				'name' => 'PressureUnit',
				'values' => [
					'ATM' => [
						'value' => Atm::class,
					],
					'BAR' => [
						'value' => Bar::class,
					],
					'PASCAL' => [
						'value' => Pascal::class,
					],
					'TORR' => [
						'value' => Torr::class,
					],
				],
			]), Pascal::class), //default value

			new InputValue('indoorTemperature', nullableFloat()),
			new InputValue('outdoorTemperature', nullableFloat()),
			new InputValue('temperatureUnit', new EnumType([ //TODO: move to the separate class
				'name' => 'TemperatureUnit',
				'values' => [
					'CELSIUS' => [
						'value' => Celsius::class,
					],
					'FAHRENHEIT' => [
						'value' => Fahrenheit::class,
					],
					'KELVIN' => [
						'value' => Kelvin::class,
					],
				],
			]), Celsius::class), //default value

			new InputValue('indoorHumidity', nullableFloat()),
			new InputValue('outdoorHumidity', nullableFloat()),
			new InputValue('humidityUnit', new EnumType([ //TODO: move to the separate class
				'name' => 'HumidityUnit',
				'values' => [
					'PERCENTAGE' => [
						'value' => Percentage::class,
					],
				],
			]), Percentage::class), //default value

			new InputValue('windSpeed', nullableFloat()),
			new InputValue('windAzimuth', nullableFloat()),
			new InputValue('windGust', nullableFloat()),
			new InputValue('windSpeedUnit', new EnumType([ //TODO: move to the separate class
				'name' => 'WindSpeedUnit',
				'values' => [
					'KMH' => [
						'value' => Kmh::class,
					],
					'MPH' => [
						'value' => Mph::class,
					],
					'MS' => [
						'value' => Ms::class,
					],
				],
			]), Kmh::class), //default value
		];
	}

}
