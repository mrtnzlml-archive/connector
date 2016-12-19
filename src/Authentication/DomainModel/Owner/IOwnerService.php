<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\DomainModel\Owner;

use Adeira\Connector\Authentication;

interface IOwnerService
{

	/**
	 * @return Authentication\DomainModel\User\User | NULL - Owner or NULL if not authorized.
	 */
	public function ownerFrom(Authentication\DomainModel\User\UserId $userId);

	public function throwInvalidOwnerException();

}
