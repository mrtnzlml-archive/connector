<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRecordRepository, WeatherStationId
};

final class ViewAllWeatherStationRecords
{

	/**
	 * @var IWeatherStationRecordRepository
	 */
	private $wsrr;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	private $weatherStationIdsBuffer = [];

	public function __construct(IWeatherStationRecordRepository $wsrr, UserIdOwnerService $ownerService)
	{
		$this->wsrr = $wsrr;
		$this->ownerService = $ownerService;
	}

	public function buffer(WeatherStationId $stationId)
	{
		$this->weatherStationIdsBuffer[$stationId->id()] = $stationId->id(); //unique
	}

	public function execute(UserId $userId, WeatherStationId $weatherStationId)
	{
		$owner = $this->ownerService->ownerFrom($userId); //FIXME: filtrovat podle uživatele!

		if(empty($this->weatherStationIdsBuffer)) {
			return $this->wsrr->ofWeatherStationId($weatherStationId);
		} else {
			static $result = NULL; //memoization
			if ($result === NULL) {
				$result = $this->wsrr->ofAllWeatherStationIds($this->weatherStationIdsBuffer);
			}
			return $result[$weatherStationId->id()];
		}
	}

}
