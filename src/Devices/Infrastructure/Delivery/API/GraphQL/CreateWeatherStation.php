<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Devices\Application\Service\WeatherStation\Command\CreateWeatherStation as CreateCommand;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStation;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;

final class CreateWeatherStation
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
		$this->commandBus->dispatch(new CreateCommand(
			$wsIdentifier = WeatherStationId::create(),
			$args['name'],
			$context->userId()
		));

		return $this->singleWeatherStation->execute(
			$context->userId(),
			$wsIdentifier
		);
	}

}
