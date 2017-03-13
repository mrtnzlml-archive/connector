<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\InMemory;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;
use Adeira\Connector\Devices\DomainModel\Camera\{
	Camera, CameraId, IAllCameras
};

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
final class InMemoryAllCameras implements IAllCameras
{

	/**
	 * @var Camera[]
	 */
	private $memory = [];

	public function add(Camera $camera): void
	{
		$this->memory[$camera->id()->toString()] = $camera;
	}

	public function withId(Owner $owner, CameraId $cameraId): ?Camera
	{
		if (isset($this->memory[$cameraId->toString()])) {
			$camera = $this->memory[$cameraId->toString()];
			if ($owner->id()->equals($camera->ownerId())) {
				return $camera;
			}
		}
		return NULL;
	}

	public function belongingTo(Owner $owner): Stub
	{
		$belonging = [];
		/** @var Camera $camera */
		foreach ($this->memory as $camera) {
			if ($owner->id()->equals($camera->ownerId())) {
				$belonging[] = $camera;
			}
		}
		return Stub::wrap($belonging);
	}

	public function nextIdentity(): CameraId
	{
		return CameraId::create();
	}

}
