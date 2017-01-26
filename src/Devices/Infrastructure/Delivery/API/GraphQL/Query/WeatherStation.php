<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Query;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\{
	ViewSingleWeatherStationService
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStationType;
use Adeira\Connector\GraphQL\Structure\{
	ArgumentSpecification, FieldSpecification
};
use GraphQL\Type\Definition;

final class WeatherStation implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var ViewSingleWeatherStationService
	 */
	private $singleWeatherStationService;

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStationType
	 */
	private $weatherStationType;

	public function __construct(
		ViewSingleWeatherStationService $singleWeatherStationService,
		WeatherStationType $weatherStationType
	) {
		$this->singleWeatherStationService = $singleWeatherStationService;
		$this->weatherStationType = $weatherStationType;
	}

	public function __invoke(): array
	{
		$weatherStationType = $this->weatherStationType;

		$wsField = new FieldSpecification('weatherStation', 'Single weather station', $weatherStationType);
		$wsField->addArguments(
			new ArgumentSpecification('id', 'ID of the weather station', Definition\Type::nonNull(Definition\Type::string()))
		);
		$wsField->setResolveFunction(function ($ancestorValue, $args, UserId $userId) {
			return $this->singleWeatherStationService->execute(
				$userId,
				WeatherStationId::createFromString($args['id'])
			);
		});

		return $wsField->buildArray();
	}

}
