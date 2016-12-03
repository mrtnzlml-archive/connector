<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\DomainModel\User;

interface IUserRepository
{

	public function add(User $aUser);

	/**
	 * @return User | NULL
	 */
	public function ofId(UserId $userId);//: ?User;

	/**
	 * @return User | NULL
	 */
	public function ofUsername(string $username);//: ?User;

	public function nextIdentity(): UserId;

}
