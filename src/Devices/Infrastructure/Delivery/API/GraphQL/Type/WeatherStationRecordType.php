<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\id;

final class WeatherStationRecordType extends \Adeira\Connector\GraphQL\Structure\Type
{

	public function getPublicTypeName(): string
	{
		return 'WeatherStationRecord';
	}

	public function getPublicTypeDescription(): string
	{
		return 'Record of the weather station';
	}

	public function defineFields(): array
	{
		return [
			$this->idFieldDefinition(),
		];
	}

	private function idFieldDefinition()
	{
		$field = new Field('id', 'ID of the weather station record', id());
		$field->setResolveFunction(function (WeatherStationRecord $wsr, $args, Context $context) {
			return $wsr->id();
		});
		return $field;
	}

}
