<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\DomainModel\User;

interface IOwnerService
{

	/**
	 * @return User|NULL - Owner or NULL if not authorized.
	 */
	public function ownerFrom(UserId $userId);

	public function throwInvalidOwnerException();

}
