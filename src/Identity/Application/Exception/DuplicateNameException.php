<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Application\Exception;

use Adeira\Connector\Identity\DomainModel\User\User;

class DuplicateNameException extends \Exception
{

	public function __construct(User $user)
	{
		parent::__construct("User with username '{$user->nickname()}' already exists.");
	}

}
