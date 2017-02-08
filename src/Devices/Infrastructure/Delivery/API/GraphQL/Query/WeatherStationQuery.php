<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Query;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStation;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationType;
use Adeira\Connector\GraphQL\Structure\Argument;
use function Adeira\Connector\GraphQL\{
	id, type
};
use GraphQL\Type\Definition;

final class WeatherStationQuery extends \Adeira\Connector\GraphQL\Structure\Query
{

	/**
	 * @var ViewSingleWeatherStation
	 */
	private $singleWeatherStationService;

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationType
	 */
	private $weatherStationType;

	public function __construct(
		ViewSingleWeatherStation $singleWeatherStationService,
		WeatherStationType $weatherStationType
	) {
		$this->singleWeatherStationService = $singleWeatherStationService;
		$this->weatherStationType = $weatherStationType;
	}

	public function getPublicQueryName(): string
	{
		return 'weatherStation';
	}

	public function getPublicQueryDescription(): string
	{
		return 'Single weather station';
	}

	public function getQueryReturnType(): Definition\ObjectType
	{
		return type($this->weatherStationType);
	}

	public function defineArguments(): ?array
	{
		return [
			new Argument('id', 'ID of the weather station', id()),
		];
	}

	public function resolve($ancestorValue, $args, UserId $userId)
	{
		return $this->singleWeatherStationService->execute(
			$userId,
			WeatherStationId::createFromString($args['id'])
		);
	}

}
