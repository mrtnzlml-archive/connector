<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\Camera;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;

interface IAllCameras
{

	public function add(Camera $camera): void;

	public function withId(Owner $owner, CameraId $cameraId): ?Camera;

	/**
	 * Returns Stub of all cameras belonging to the Owner.
	 */
	public function belongingTo(Owner $owner): Stub;

	/**
	 * Returns next available Camera identifier.
	 */
	public function nextIdentity(): CameraId;

}
