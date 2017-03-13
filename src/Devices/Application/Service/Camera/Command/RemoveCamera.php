<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\Camera\Command;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;

/**
 * This is just simple DTO and should be filled by form in presenter or by command in CLI.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
final class RemoveCamera implements \Adeira\Connector\ServiceBus\DomainModel\ICommand
{

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\User\UserId
	 */
	private $userId;

	/**
	 * @var \Adeira\Connector\Devices\DomainModel\Camera\CameraId
	 */
	private $cameraId;

	public function __construct(UserId $userId, CameraId $cameraId)
	{
		$this->userId = $userId;
		$this->cameraId = $cameraId;
	}

	public function userId(): UserId
	{
		return $this->userId;
	}

	public function cameraId(): CameraId
	{
		return $this->cameraId;
	}

}
