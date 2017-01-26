<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\DomainModel\User;

interface IUserRepository
{

	public function add(User $aUser);

	public function ofId(UserId $userId): ?User;

	public function ofUsername(string $username): ?User;

	public function nextIdentity(): UserId;

}
