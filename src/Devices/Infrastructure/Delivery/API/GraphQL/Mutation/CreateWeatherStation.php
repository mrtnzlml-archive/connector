<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Mutation;

use Adeira\Connector\Devices\Application\Service\WeatherStation\Command\CreateWeatherStation as CreateCommand;
use Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStation;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationType;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Structure\Argument;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;
use function Adeira\Connector\GraphQL\{
	string, type
};
use GraphQL\Type\Definition\ObjectType;

final class CreateWeatherStation extends \Adeira\Connector\GraphQL\Structure\Mutation
{

	/**
	 * @var \Adeira\Connector\Devices\Infrastructure\Delivery\API\GraphQL\Type\WeatherStationType
	 */
	private $weatherStationType;

	/**
	 * @var \Adeira\Connector\ServiceBus\DomainModel\ICommandBus
	 */
	private $commandBus;

	/**
	 * @var \Adeira\Connector\Devices\Application\Service\WeatherStation\ViewSingleWeatherStation
	 */
	private $singleWeatherStation;

	public function __construct(WeatherStationType $weatherStationType, ICommandBus $commandBus, ViewSingleWeatherStation $singleWeatherStation)
	{
		$this->weatherStationType = $weatherStationType;
		$this->commandBus = $commandBus;
		$this->singleWeatherStation = $singleWeatherStation;
	}

	public function getPublicQueryName(): string
	{
		return 'createWeatherStation';
	}

	public function getPublicQueryDescription(): string
	{
		return 'Create new weather station.';
	}

	public function getQueryReturnType(): ObjectType
	{
		return type($this->weatherStationType);
	}

	public function defineArguments(): ?array
	{
		return [
			new Argument(
				'name',
				'Name of the new weather station', string()
			),
		];
	}

	public function resolve($ancestorValue, $args, Context $context)
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
