<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStationsService;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\{
	int, listOf
};

final class WeatherStationsConnectionType extends \Adeira\Connector\GraphQL\Structure\Type
{

	private $wst;

	private $wsEdge;

	private $allWeatherStationsService;

	public function __construct(
		WeatherStationType $wst,
		WeatherStationsEdgeType $wsEdge,
		ViewAllWeatherStationsService $allWeatherStationsService
	)
	{
		$this->wst = $wst;
		$this->wsEdge = $wsEdge;
		$this->allWeatherStationsService = $allWeatherStationsService;
	}

	public function getPublicTypeName(): string
	{
		return 'WeatherStationsConnection';
	}

	public function getPublicTypeDescription(): string
	{
		return 'Connection to the weather stations';
	}

	public function defineFields(): array
	{
		return [
			//TODO: pageInfo:(hasNextPage, hasPreviousPage, startCursor, endCursor)
			$this->edgesFieldDefinition(),
			$this->totalCountFieldDefinition(),
			$this->weatherStationsFieldDefinition(),
		];
	}

	private function edgesFieldDefinition()
	{
		return new Field('edges', 'Contains all nodes with cursors.', listOf($this->wsEdge));
	}

	private function totalCountFieldDefinition()
	{
		$field = new Field('totalCount', 'Total count of all weather stations.', int());
		$field->setResolveFunction(function (array $weatherStations, $args, UserId $userId) {
			return $this->allWeatherStationsService->executeCountOnly($userId);
		});
		return $field;
	}

	private function weatherStationsFieldDefinition()
	{
		return new Field('weatherStations', 'All weather stations.', listOf($this->wst));
	}

}
