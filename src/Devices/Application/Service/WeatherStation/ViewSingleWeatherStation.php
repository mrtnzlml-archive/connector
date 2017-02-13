<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRepository,
	WeatherStationId
};

final class ViewSingleWeatherStation
{

	/**
	 * @var IWeatherStationRepository
	 */
	private $weatherStationRepository;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	public function __construct(IWeatherStationRepository $weatherStationRepository, UserIdOwnerService $ownerService)
	{
		$this->weatherStationRepository = $weatherStationRepository;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, WeatherStationId $weatherStationId)
	{
		$owner = $this->ownerService->existingOwner($userId);
		return $this->weatherStationRepository->ofId($weatherStationId, $owner);
	}

}
