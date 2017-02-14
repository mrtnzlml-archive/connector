<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IAllWeatherStations;

final class CountAllWeatherStations
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

	public function execute(UserId $userId)
	{
		$owner = $this->ownerService->existingOwner($userId);
		$stub = $this->allWeatherStations->belongingTo($owner);
		return $stub->hydrateCount();
	}

}
