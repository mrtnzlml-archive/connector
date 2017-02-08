<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation\Command;

use Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IWeatherStationRepository;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStation;

/**
 * Application services should depend on abstraction (interfaces) so we'll make our Application Service immune to
 * low-level Infrastructure changes. It's important to keep your Application Services setup out of the Infrastructure
 * boundary. Also those services should be registered in DIC.
 */
final class CreateWeatherStationHandler
{

	private $weatherStationRepository;

	private $ownerService;

	public function __construct(
		IWeatherStationRepository $weatherStationRepository,
		IOwnerService $ownerService
	) {
		$this->weatherStationRepository = $weatherStationRepository;
		$this->ownerService = $ownerService;
	}

	public function __invoke(CreateWeatherStation $aCommand)
	{
		$owner = $this->ownerService->ownerFrom($aCommand->userId());
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}

		$this->weatherStationRepository->add($weatherStation = new WeatherStation(
			$this->weatherStationRepository->nextIdentity(),
			$owner,
			$aCommand->name()
		));
	}

}
