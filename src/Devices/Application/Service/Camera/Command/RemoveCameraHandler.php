<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\Camera\Command;

use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\Camera\IAllCameras;

final class RemoveCameraHandler
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

	public function __invoke(RemoveCamera $aCommand): void
	{
		$owner = $this->ownerService->existingOwner($aCommand->userId());
		$camera = $this->allCameras->withId($owner, $aCommand->cameraId());

		//FIXME: throw exception if ($camera === NULL) ?
		if ($camera !== NULL) {
			$this->allCameras->remove($camera);
		}
	}

}
