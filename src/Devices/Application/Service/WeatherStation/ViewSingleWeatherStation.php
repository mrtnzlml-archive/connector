<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\{
	Owner\IOwnerService,
	User\UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRepository,
	WeatherStationId
};

final class ViewSingleWeatherStation
{

	/**
	 * @var IWeatherStationRepository
	 */
	private $weatherStationRepository;

	/**
	 * @var IOwnerService
	 */
	private $ownerService;

	public function __construct(IWeatherStationRepository $weatherStationRepository, IOwnerService $ownerService)
	{
		$this->weatherStationRepository = $weatherStationRepository;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, WeatherStationId $weatherStationId)
	{
		$owner = $this->ownerService->ownerFrom($userId);
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}

		return $this->weatherStationRepository->ofId($weatherStationId);
	}

}
