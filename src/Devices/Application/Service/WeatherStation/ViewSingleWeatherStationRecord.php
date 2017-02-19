<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStationRecords, IAllWeatherStations, WeatherStationId, WeatherStationRecord, WeatherStationRecordId
};

final class ViewSingleWeatherStationRecord
{

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStations
	 */
	private $allWeatherStations;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationRecords
	 */
	private $allRecords;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	public function __construct(IAllWeatherStations $allWeatherStations, IAllWeatherStationRecords $allRecords, UserIdOwnerService $ownerService)
	{
		$this->allWeatherStations = $allWeatherStations;
		$this->allRecords = $allRecords;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, WeatherStationId $weatherStationId, WeatherStationRecordId $recordId): WeatherStationRecord
	{
		$owner = $this->ownerService->existingOwner($userId);
		$weatherStation = $this->allWeatherStations->withId($owner, $weatherStationId)->hydrateOne();

		if (!$owner->id()->equals($weatherStation->ownerId())) {
			throw new \InvalidArgumentException('User is not authorized to view this weather station.');
		}

		return $this->allRecords->withId($weatherStation, $recordId)->hydrateOne();
	}

}
