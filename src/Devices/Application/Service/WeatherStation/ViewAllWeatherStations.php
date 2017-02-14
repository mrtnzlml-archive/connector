<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStations;
use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;

final class ViewAllWeatherStations
{

	/**
	 * @var IAllWeatherStations
	 */
	private $allWeatherStations;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	public function __construct(IAllWeatherStations $allWeatherStations, UserIdOwnerService $ownerService)
	{
		$this->allWeatherStations = $allWeatherStations;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, ?int $limit, ?WeatherStationId $fromWeatherStationId)
	{
		$owner = $this->ownerService->existingOwner($userId);
		$stub = $this->allWeatherStations->belongingTo($owner);
		$stub->orientation('creationDate'); //FIXME: to by zde asi nemělo být (? detail entity)
		if ($limit !== NULL) {
			$stub->first($limit);
		}
		if ($fromWeatherStationId !== NULL) {
			$stub->after($fromWeatherStationId);
		}
		return $stub->hydrate();
	}

}
