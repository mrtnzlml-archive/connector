<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStations;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;

final class RenameWeatherStationHandler
{

	/**
	 * @var IAllWeatherStations
	 */
	private $allWeatherStations;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	public function __construct(IAllWeatherStations $allWeatherStations, UserIdOwnerService $ownerService)
	{
		$this->allWeatherStations = $allWeatherStations;
		$this->ownerService = $ownerService;
	}

	public function __invoke(RenameWeatherStation $aCommand)
	{
		$owner = $this->ownerService->existingOwner($aCommand->userId());
		$stub = $this->allWeatherStations->withId($owner, $aCommand->weatherStationId());
		/** @var WeatherStation $weatherStation */
		$weatherStation = $stub->hydrateOne();

		$weatherStation->rename($aCommand->newStationName());
	}

}
