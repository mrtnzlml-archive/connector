<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStations, IAllWeatherStationRecords, WeatherStationId
};

final class ViewAllWeatherStationRecords
{

	private $allWeatherStations;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationRecords
	 */
	private $allRecords;

	private $weatherStationIdsBuffer = [];

	public function __construct(IAllWeatherStations $allWeatherStations, UserIdOwnerService $ownerService, IAllWeatherStationRecords $allRecords)
	{
		$this->allWeatherStations = $allWeatherStations;
		$this->ownerService = $ownerService;
		$this->allRecords = $allRecords;
	}

	public function buffer(WeatherStationId $stationId)
	{
		$this->weatherStationIdsBuffer[$stationId->id()] = $stationId->id(); //unique
	}

	public function execute(UserId $userId, WeatherStationId $weatherStationId)
	{
		$owner = $this->ownerService->existingOwner($userId);
		$weatherStation = $this->allWeatherStations->withId($owner, $weatherStationId)->hydrateOne();
		if (!$owner->id()->equals($weatherStation->ownerId())) {
			throw new \InvalidArgumentException('User is not authorized to view this weather station.');
		}

		if (empty($this->weatherStationIdsBuffer)) {
			return $this->allRecords->ofWeatherStationId($weatherStationId);
		} else {
			static $result = NULL; //memoization
			if ($result === NULL) {
				$result = $this->allRecords->ofAllWeatherStationIds($this->weatherStationIdsBuffer);
			}
			return $result[$weatherStationId->id()] ?? NULL;
		}
	}

}
