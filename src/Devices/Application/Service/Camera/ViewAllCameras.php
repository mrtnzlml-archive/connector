<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\Camera;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\UserIdOwnerService;
use Adeira\Connector\Devices\DomainModel\Camera\IAllCameras;

final class ViewAllCameras
{

	/**
	 * @var UserIdOwnerService
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

	public function execute(UserId $userId)
	{
		$owner = $this->ownerService->existingOwner($userId);
		$stub = $this->allCameras->belongingTo($owner);
		return $stub->hydrate();
	}

}
