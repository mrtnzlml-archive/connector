<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationSeries;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\{
	id, string
};

final class WeatherStationSeriesType extends \Adeira\Connector\GraphQL\Structure\Type
{

	public function getPublicTypeName(): string
	{
		return 'WeatherStationSeries';
	}

	public function getPublicTypeDescription(): string
	{
		return 'Weather station series';
	}

	public function defineFields(): array
	{
		return [
			$this->idFieldDefinition(),
			$this->nameFieldDefinition(),
		];
	}

	private function idFieldDefinition()
	{
		$field = new Field('id', 'ID of the weather station series', id());
		$field->setResolveFunction(function (WeatherStationSeries $series, $args, Context $context) {
			return $series->id();
		});
		return $field;
	}

	private function nameFieldDefinition()
	{
		$field = new Field('name', 'Name of the weather station', string());
		$field->setResolveFunction(function (WeatherStationSeries $series, $args, Context $context) {
			return $series->code();
		});
		return $field;
	}

}
