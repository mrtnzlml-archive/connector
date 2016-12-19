<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IWeatherStationRepository;

class ViewAllWeatherStationsService
{

	/**
	 * @var IWeatherStationRepository
	 */
	private $weatherStationRepository;

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService
	 */
	private $ownerService;

	public function __construct(IWeatherStationRepository $weatherStationRepository, IOwnerService $ownerService)
	{
		$this->weatherStationRepository = $weatherStationRepository;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId)
	{
		$owner = $this->ownerService->ownerFrom($userId);
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}

		return $this->weatherStationRepository->all($userId);
	}

}
