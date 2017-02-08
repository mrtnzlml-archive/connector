<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStationRecords;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\{
	id, listOf, string
};

final class WeatherStationType extends \Adeira\Connector\GraphQL\Structure\Type
{

	private $wsrt;

	private $allWsRecords;

	public function __construct(WeatherStationRecordType $wsrt, ViewAllWeatherStationRecords $allWsRecords)
	{
		$this->wsrt = $wsrt;
		$this->allWsRecords = $allWsRecords;
	}

	public function getPublicTypeName(): string
	{
		return 'WeatherStation';
	}

	public function getPublicTypeDescription(): string
	{
		return 'Weather station';
	}

	public function defineFields(): array
	{
		return [
			$this->idFieldDefinition(),
			$this->nameFieldDefinition(),
			$this->recordsFieldDefinition(),
		];
	}

	private function idFieldDefinition()
	{
		$field = new Field('id', 'ID of the weather station', id());
		$field->setResolveFunction(function (WeatherStation $ws, $args, UserId $userId) {
			return $ws->id();
		});
		return $field;
	}

	private function nameFieldDefinition()
	{
		$field = new Field('name', 'Name of the weather station', string());
		$field->setResolveFunction(function (WeatherStation $obj, $args, UserId $userId) {
			return $obj->deviceName();
		});
		return $field;
	}

	private function recordsFieldDefinition()
	{
		$field = new Field('records', 'Records of the weather station', listOf($this->wsrt));
		$field->setResolveFunction(function (WeatherStation $ws, $args, UserId $userId) {
			$this->allWsRecords->buffer($ws->id());

			return new \GraphQL\Deferred(function() use ($userId, $ws) {
				return $this->allWsRecords->execute($userId, $ws->id());
			});
		});
		return $field;
	}

}
