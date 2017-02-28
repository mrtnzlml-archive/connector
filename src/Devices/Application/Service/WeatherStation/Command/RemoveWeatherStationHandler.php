<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStations;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;

final class RemoveWeatherStationHandler
{

	/**
	 * @var IAllWeatherStations
	 */
	private $allStations;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	public function __construct(IAllWeatherStations $allStations, UserIdOwnerService $ownerService)
	{
		$this->allStations = $allStations;
		$this->ownerService = $ownerService;
	}

	public function __invoke(RemoveWeatherStation $aCommand)
	{
		$owner = $this->ownerService->existingOwner($aCommand->userId());
		/** @var WeatherStation $weatherStation */
		$weatherStation = $this->allStations->withId($owner, $aCommand->weatherStationId())->hydrateOne();

		$this->allStations->remove($weatherStation);
	}

}
