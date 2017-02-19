<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStations, IAllWeatherStationRecords, WeatherStation, WeatherStationId
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

	private $weatherStationsBuffer = [];

	public function __construct(IAllWeatherStations $allWeatherStations, UserIdOwnerService $ownerService, IAllWeatherStationRecords $allRecords)
	{
		$this->allWeatherStations = $allWeatherStations;
		$this->ownerService = $ownerService;
		$this->allRecords = $allRecords;
	}

	public function buffer(WeatherStation $station)
	{
		$this->weatherStationsBuffer[(string)$station->id()] = $station; //must be unique
	}

	/**
	 * @return \Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord[]|null
	 */
	public function execute(UserId $userId, WeatherStationId $weatherStationId)
	{
		$owner = $this->ownerService->existingOwner($userId);
		$weatherStation = $this->allWeatherStations->withId($owner, $weatherStationId)->hydrateOne();

		if (!$owner->id()->equals($weatherStation->ownerId())) {
			throw new \InvalidArgumentException('User is not authorized to view this weather station.');
		}

		if (empty($this->weatherStationsBuffer)) {
			return $this->allRecords->ofWeatherStation($weatherStation)->hydrate();
		} else {
			static $result = NULL; //memoization
			if ($result === NULL) {
				$result = $this->allRecords->ofAllWeatherStations(array_values($this->weatherStationsBuffer));
			}
			return $result[$weatherStationId->id()] ?? NULL;
		}
	}

}
