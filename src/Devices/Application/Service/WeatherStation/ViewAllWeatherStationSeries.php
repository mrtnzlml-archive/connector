<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\{
	Owner\IOwnerService, User\UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\IWeatherStationSeriesRepository;

final class ViewAllWeatherStationSeries
{

	private $seriesRepository;

	private $ownerService;

	public function __construct(IWeatherStationSeriesRepository $seriesRepository, IOwnerService $ownerService)
	{
		$this->seriesRepository = $seriesRepository;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId)
	{
		$this->assertOwnerPermissions($userId);
		return $this->seriesRepository->all();
	}

	public function assertOwnerPermissions(UserId $userId)
	{
		$owner = $this->ownerService->ownerFrom($userId);
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}
	}

}
