<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\{
	string, type
};

final class WeatherStationsEdgeType extends \Adeira\Connector\GraphQL\Structure\Type
{

	private $wsType;

	public function __construct(WeatherStationType $wsType)
	{
		$this->wsType = $wsType;
	}

	public function getPublicTypeName(): string
	{
		return 'WeatherStationsEdgeType';
	}

	public function getPublicTypeDescription(): string
	{
		return 'An edge in the weather stations connection';
	}

	public function defineFields(): array
	{
		return [
			$this->cursorFieldDefinition(),
			$this->nodeFieldDefinition(),
		];
	}

	private function cursorFieldDefinition()
	{
		$field = new Field('cursor', 'Cursor of the record.', string());
		$field->setResolveFunction(function (WeatherStation $weatherStation) {
			return base64_encode((string)$weatherStation->id());
		});
		return $field;
	}

	private function nodeFieldDefinition()
	{
		return new Field('node', 'One weather station.', type($this->wsType));
	}

}
