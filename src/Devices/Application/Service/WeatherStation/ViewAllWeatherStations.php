<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\WeatherStation\IWeatherStationRepository;
use Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine\AllWeatherStationsSpecification;

final class ViewAllWeatherStations
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

	public function execute(UserId $userId, $limit, $fromWeatherStationId)
	{
		$owner = $this->ownerService->existingOwner($userId); //FIXME: filtrovat podle uživatele!

		return $this->weatherStationRepository->findBySpecification(
			new AllWeatherStationsSpecification($userId, $limit, $fromWeatherStationId)
		);
	}

	public function executeCountOnly(UserId $userId): int
	{
		$owner = $this->ownerService->existingOwner($userId); //FIXME: filtrovat podle uživatele!

		return $this->weatherStationRepository->countBySpecification(
			new AllWeatherStationsSpecification($userId, NULL, NULL)
		);
	}

}
