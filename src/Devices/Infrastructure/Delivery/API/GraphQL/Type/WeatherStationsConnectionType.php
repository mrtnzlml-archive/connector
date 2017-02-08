<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type;

use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStationSeries;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewAllWeatherStations;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Structure\Field;
use function Adeira\Connector\GraphQL\{
	int, listOf
};

final class WeatherStationsConnectionType extends \Adeira\Connector\GraphQL\Structure\Type
{

	private $wst;

	private $wsEdge;

	private $allWeatherStationsService;

	private $weatherStationSeriesType;

	private $allWeatherStationsSeries;

	public function __construct(
		WeatherStationType $wst,
		WeatherStationsEdgeType $wsEdge,
		ViewAllWeatherStations $allWeatherStationsService,
		WeatherStationSeriesType $weatherStationSeriesType,
		ViewAllWeatherStationSeries $allWeatherStationsSeries
	) {
		$this->wst = $wst;
		$this->wsEdge = $wsEdge;
		$this->allWeatherStationsService = $allWeatherStationsService;
		$this->weatherStationSeriesType = $weatherStationSeriesType;
		$this->allWeatherStationsSeries = $allWeatherStationsSeries;
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
			$this->seriesFieldDefinition(),
		];
	}

	private function edgesFieldDefinition()
	{
		return new Field('edges', 'Contains all nodes with cursors.', listOf($this->wsEdge));
	}

	private function totalCountFieldDefinition()
	{
		$field = new Field('totalCount', 'Total count of all weather stations.', int());
		$field->setResolveFunction(function (array $weatherStations, $args, Context $context) {
			return $this->allWeatherStationsService->executeCountOnly($context->userId());
		});
		return $field;
	}

	private function weatherStationsFieldDefinition()
	{
		return new Field('weatherStations', 'All weather stations.', listOf($this->wst));
	}

	private function seriesFieldDefinition()
	{
		$field = new Field(
			'series',
			'All weather station production series known by this system.',
			listOf($this->weatherStationSeriesType)
		);
		$field->setResolveFunction(function(array $weatherStations, $args, Context $context) {
			return $this->allWeatherStationsSeries->execute($context->userId());
		});
		return $field;
	}

}
