<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\Camera\Query;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\Devices\DomainModel\Camera\IAllCameras;

final class SingleCamera
{

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Camera\IAllCameras
	 */
	private $allCameras;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	public function __construct(IAllCameras $allCameras, UserIdOwnerService $ownerService)
	{
		$this->allCameras = $allCameras;
		$this->ownerService = $ownerService;
	}

	public function __invoke(UserId $userId, CameraId $cameraId): ?Camera
	{
		$owner = $this->ownerService->existingOwner($userId);
		return $this->allCameras->withId($owner, $cameraId);
	}

}
