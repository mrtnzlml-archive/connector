<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\DomainModel\Owner;

use Adeira\Connector\Authentication\DomainModel\User;

interface IOwnerService
{

	public function ownerFrom(User\UserId $userId): ?User\User;

	public function throwInvalidOwnerException();

}
