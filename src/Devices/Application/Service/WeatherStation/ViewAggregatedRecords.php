<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAggregatedWeatherStationRecords, IAllWeatherStations, RecordAggregationRange, WeatherStationId
};

final class ViewAggregatedRecords
{

	private $allWeatherStations;

	private $ownerService;

	private $records;

	public function __construct(IAllWeatherStations $allWeatherStations, UserIdOwnerService $ownerService, IAggregatedWeatherStationRecords $records)
	{
		$this->allWeatherStations = $allWeatherStations;
		$this->ownerService = $ownerService;
		$this->records = $records;
	}

	/**
	 * @return \Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecord[]|null
	 */
	public function execute(
		UserId $userId,
		WeatherStationId $weatherStationId,
		\DateTimeImmutable $until,
		int $recordsForEachStation,
		RecordAggregationRange $aggregation
	) {
		$owner = $this->ownerService->existingOwner($userId);
		$weatherStation = $this->allWeatherStations->withId($owner, $weatherStationId)->hydrateOne();

		if (!$owner->id()->equals($weatherStation->ownerId())) {
			throw new \InvalidArgumentException('User is not authorized to view this weather station.');
		}

		return $this->records->ofSingleWeatherStation($weatherStation, $until, $recordsForEachStation, $aggregation);
	}

}
