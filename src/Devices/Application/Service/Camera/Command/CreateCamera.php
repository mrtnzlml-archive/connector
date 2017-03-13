<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Application\Service\Camera\Command;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Adeira\Connector\ServiceBus\DomainModel\ICommand;

/**
 * This is just simple DTO and should be filled by form in presenter or by command in CLI.
 *  - use primitives
 *  - make it serializable
 *  - no business logic
 *  - no tests
 */
final class CreateCamera implements ICommand
{

	private $streamSource;

	private $cameraName;

	private $userId;

	private $cameraId;

	public function __construct(string $streamSource, string $cameraName, UserId $userId, CameraId $cameraId)
	{
		$this->streamSource = $streamSource;
		$this->cameraName = $cameraName;
		$this->userId = $userId;
		$this->cameraId = $cameraId;
	}

	public function streamSource(): string
	{
		return $this->streamSource;
	}

	public function cameraName(): string
	{
		return $this->cameraName;
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
