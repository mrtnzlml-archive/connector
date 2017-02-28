<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\WeatherStation\Mutation;

use Adeira\Connector\Devices\Application\Service\WeatherStation\Command\RemoveWeatherStation as RemoveCommand;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStation;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;

final class RemoveWeatherStation
{

	/**
	 * @var \Adeira\Connector\ServiceBus\DomainModel\ICommandBus
	 */
	private $commandBus;

	/**
	 * @var \Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStation
	 */
	private $singleWeatherStation;

	public function __construct(ICommandBus $commandBus, ViewSingleWeatherStation $singleWeatherStation)
	{
		$this->commandBus = $commandBus;
		$this->singleWeatherStation = $singleWeatherStation;
	}

	public function __invoke($ancestorValue, $args, Context $context)
	{
		$stationId = WeatherStationId::createFromString($args['stationId']);
		$originalStation = $this->singleWeatherStation->execute($context->userId(), $stationId);

		$this->commandBus->dispatch(new RemoveCommand(
			$context->userId(),
			$stationId
		));

		return $originalStation;
	}

}
