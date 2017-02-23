<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\Camera;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Authentication\DomainModel\User\UserId;

/**
 * This is entity without mapping. Mapping is infrastructure detail.
 *
 * @see Infrastructure/Persistence/Doctrine/Mapping/Adeira.Connector.Devices.DomainModel.Camera.Camera.dcm.xml
 */
final class Camera
{

	/**
	 * @var CameraId
	 */
	private $id;

	/**
	 * @var UserId
	 */
	private $ownerId;

	/**
	 * @var string
	 */
	private $cameraName;

	/**
	 * @var \DateTimeImmutable
	 */
	private $creationDate;

	public function __construct(CameraId $id, Owner $owner, string $cameraName, \DateTimeImmutable $creationDate)
	{
		$this->id = $id;
		$this->ownerId = $owner->id();
		$this->cameraName = $cameraName;
		$this->creationDate = $creationDate;
	}

	public function id(): CameraId
	{
		return $this->id;
	}

	public function ownerId(): UserId
	{
		return $this->ownerId;
	}

	public function cameraName(): string
	{
		return $this->cameraName;
	}

	public function creationDate()
	{
		return $this->creationDate;
	}

}
