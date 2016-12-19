<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\{
	Application\Service\WeatherStation\ViewAllWeatherStationsService,
	Application\Service\WeatherStation\ViewSingleWeatherStationService,
	DomainModel\WeatherStation\WeatherStationId
};
use GraphQL\Type\Definition;

class WeatherStationQueryDefinition implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var ViewAllWeatherStationsService
	 */
	private $allWeatherStationsService;

	/**
	 * @var ViewSingleWeatherStationService
	 */
	private $singleWeatherStationService;

	public function __construct(
		ViewAllWeatherStationsService $allWeatherStationsService,
		ViewSingleWeatherStationService $singleWeatherStationService
	) {
		$this->allWeatherStationsService = $allWeatherStationsService;
		$this->singleWeatherStationService = $singleWeatherStationService;
	}

	/**
	 * device(id: String!): InboundSource
	 */
	public function __invoke(): array
	{
		$weatherStationType = (new WeatherStationType)(); //FIXME: singleton
		return [
			'device' => [
				'type' => $weatherStationType,
				'args' => [
					'id' => [
						'name' => 'id',
						'description' => 'The ID of the data source.',
						'type' => Definition\Type::nonNull(
							Definition\Type::string()
						),
					],
				],
				'resolve' => function ($obj, $args, UserId $userId) {
					return $this->singleWeatherStationService->execute(
						$userId,
						WeatherStationId::createFromString($args['id'])
					);
				},
			],
			'devices' => [
				'type' => Definition\Type::listOf($weatherStationType),
				'resolve' => function ($obj, $args, UserId $userId) {
					return $this->allWeatherStationsService->execute($userId);
				},
			],
		];
	}

}
