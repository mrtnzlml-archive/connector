<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\Camera\Command;

use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\Camera\Camera;
use Adeira\Connector\Devices\DomainModel\Camera\IAllCameras;
use Adeira\Connector\Devices\DomainModel\Camera\Stream;
use Adeira\Connector\Devices\DomainModel\Camera\StreamService;
use Ramsey\Uuid\Uuid;

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

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Camera\StreamService
	 */
	private $streamService;

	public function __construct(UserIdOwnerService $ownerService, IAllCameras $allCameras, StreamService $streamService)
	{
		$this->ownerService = $ownerService;
		$this->allCameras = $allCameras;
		$this->streamService = $streamService;
	}

	public function __invoke(CreateCamera $aCommand): void
	{
		$owner = $this->ownerService->existingOwner($aCommand->userId());

		$stream = $this->streamService->startStream($aCommand->streamSource());

		$this->allCameras->add(
			Camera::create(
				$aCommand->cameraId(),
				$owner,
				$aCommand->cameraName(),
				$stream
			)
		);
	}

}
