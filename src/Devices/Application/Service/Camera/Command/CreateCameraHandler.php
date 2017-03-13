<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\Camera\Command;

use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\IAllCameras;

/**
 * Application services should depend on abstraction (interfaces) so we'll make our Application Service immune to
 * low-level Infrastructure changes. It's important to keep your Application Services setup out of the Infrastructure
 * boundary. Also those services should be registered in DIC.
 */
final class CreateCameraHandler
{

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService
	 */
	private $ownerService;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Camera\IAllCameras
	 */
	private $allCameras;

	public function __construct(UserIdOwnerService $ownerService, IAllCameras $allCameras)
	{
		$this->ownerService = $ownerService;
		$this->allCameras = $allCameras;
	}

	public function __invoke(CreateCamera $aCommand): void
	{
		$owner = $this->ownerService->existingOwner($aCommand->userId());

		$this->allCameras->add(
			Camera::create(
				$aCommand->cameraId(),
				$owner,
				$aCommand->cameraName(),
				$aCommand->streamSource()
			)
		);
	}

}
