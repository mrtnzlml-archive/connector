<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationSeries;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\string;

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
			$this->nameFieldDefinition(),
		];
	}

	private function nameFieldDefinition()
	{
		$field = new Field('name', 'Name of the weather station', string());
		$field->setResolveFunction(function (WeatherStationSeries $series, $args, UserId $userId) {
			return $series->code();
		});
		return $field;
	}

}
