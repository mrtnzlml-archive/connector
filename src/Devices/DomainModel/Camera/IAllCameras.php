<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\DomainModel\Camera;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;

interface IAllCameras
{

	/**
	 * Add Camera entity to the repository.
	 * It's without Owner because it should not be possible to bet Camera without Owner.
	 */
	public function add(Camera $camera): void;

	/**
	 * Remove Camera entity from the repository.
	 * It's without Owner because it should not be possible to bet Camera without Owner.
	 */
	public function remove(Camera $camera): void;

	/**
	 * Get single Camera by ID or return NULL if doesn't exist.
	 */
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
