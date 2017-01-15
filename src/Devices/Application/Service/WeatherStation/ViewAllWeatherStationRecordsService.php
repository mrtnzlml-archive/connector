<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\{
	Owner\IOwnerService, User\UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRecordRepository, WeatherStationId
};

class ViewAllWeatherStationRecordsService
{

	/**
	 * @var IWeatherStationRecordRepository
	 */
	private $wsrr;

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService
	 */
	private $ownerService;

	public function __construct(IWeatherStationRecordRepository $wsrr, IOwnerService $ownerService)
	{
		$this->wsrr = $wsrr;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, WeatherStationId $weatherStationId)
	{
		$owner = $this->ownerService->ownerFrom($userId);
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}

		return $this->wsrr->ofWeatherStationId($weatherStationId);
	}

}
