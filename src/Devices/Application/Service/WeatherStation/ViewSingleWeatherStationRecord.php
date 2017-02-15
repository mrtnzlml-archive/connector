<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IAllWeatherStationRecords, WeatherStationRecord, WeatherStationRecordId
};

final class ViewSingleWeatherStationRecord
{

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStationRecords
	 */
	private $allRecords;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	public function __construct(IAllWeatherStationRecords $allRecords, UserIdOwnerService $ownerService)
	{
		$this->allRecords = $allRecords;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, WeatherStationRecordId $recordId): WeatherStationRecord
	{
		$owner = $this->ownerService->existingOwner($userId);
		return $this->allRecords->withId($owner, $recordId)->hydrateOne();
	}

}
