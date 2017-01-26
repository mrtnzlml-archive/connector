<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Query;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\{
	ViewAllWeatherStationsService
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStationsConnection;
use Adeira\Connector\GraphQL\Structure\{
	ArgumentSpecification, FieldSpecification
};
use GraphQL\Type\Definition;

class AllWeatherStations implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var ViewAllWeatherStationsService
	 */
	private $allWeatherStationsService;

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStationsConnection
	 */
	private $weatherStationsConnection;

	public function __construct(
		ViewAllWeatherStationsService $allWeatherStationsService,
		WeatherStationsConnection $weatherStationsConnection
	) {
		$this->allWeatherStationsService = $allWeatherStationsService;
		$this->weatherStationsConnection = $weatherStationsConnection;
	}

	public function __invoke(): array
	{
		$wsField = new FieldSpecification('allWeatherStations', 'All weather stations', $this->weatherStationsConnection);
		$wsField->addArguments(
			new ArgumentSpecification('first', 'How many records do you want', Definition\Type::int()),
			new ArgumentSpecification('after', 'Last cursor', Definition\Type::string())
		);
		$wsField->setResolveFunction(function ($ancestorValue, $args, UserId $userId) {
			$limit = $args['first'] ?? NULL;
			$fromWeatherStationId = isset($args['after']) ? WeatherStationId::createFromString(base64_decode($args['after'])) : NULL;
			return $this->allWeatherStationsService->execute($userId, $limit, $fromWeatherStationId);
		});

		return $wsField->buildArray();
	}

}
