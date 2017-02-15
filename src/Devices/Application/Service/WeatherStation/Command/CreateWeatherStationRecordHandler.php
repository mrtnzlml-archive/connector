<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationRecords;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStations;

/**
 * Application services should depend on abstraction (interfaces) so we'll make our Application Service immune to
 * low-level Infrastructure changes. It's important to keep your Application Services setup out of the Infrastructure
 * boundary. Also those services should be registered in DIC.
 */
final class CreateWeatherStationRecordHandler
{

	private $allWeatherStationRecords;

	private $ownerService;

	private $allStations;

	public function __construct(
		IAllWeatherStationRecords $allWeatherStationRecords,
		UserIdOwnerService $ownerService,
		IAllWeatherStations $allStations
	) {
		$this->allWeatherStationRecords = $allWeatherStationRecords;
		$this->ownerService = $ownerService;
		$this->allStations = $allStations;
	}

	public function __invoke(CreateWeatherStationRecord $aCommand)
	{
		$owner = $this->ownerService->existingOwner($aCommand->userId());

		/** @var \Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation $weatherStation */
		$weatherStation = $this->allStations->withId($owner, $aCommand->stationId())->hydrateOne();

		$this->allWeatherStationRecords->add(
			$weatherStation->makeWeatherStationRecord(
				$aCommand->recordId(),
				$aCommand->physicalQuantities()
			)
		);
	}

}
