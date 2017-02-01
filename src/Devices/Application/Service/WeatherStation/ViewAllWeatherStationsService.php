<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\WeatherStation;

use Adeira\Connector\Authentication\DomainModel\{
	Owner\IOwnerService, User\UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\IWeatherStationRepository;
use Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine\AllWeatherStationsSpecification;

final class ViewAllWeatherStationsService
{

	/**
	 * @var IWeatherStationRepository
	 */
	private $weatherStationRepository;

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService
	 */
	private $ownerService;

	public function __construct(IWeatherStationRepository $weatherStationRepository, IOwnerService $ownerService)
	{
		$this->weatherStationRepository = $weatherStationRepository;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, $limit, $fromWeatherStationId)
	{
		$this->assertOwnerPermissions($userId);
		return $this->weatherStationRepository->findBySpecification(
			new AllWeatherStationsSpecification($userId, $limit, $fromWeatherStationId)
		);
	}

	public function executeCountOnly(UserId $userId): int
	{
		$this->assertOwnerPermissions($userId);
		return $this->weatherStationRepository->countBySpecification(
			new AllWeatherStationsSpecification($userId, NULL, NULL)
		);
	}

	public function assertOwnerPermissions(UserId $userId)
	{
		$owner = $this->ownerService->ownerFrom($userId);
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}
	}

}
