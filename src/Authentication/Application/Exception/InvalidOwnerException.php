<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Application\Exception;

class InvalidOwnerException extends \Exception
{

	public function __construct(string $message = NULL)
	{
		parent::__construct('Owner is not valid or it doesn\'t have enough permissions. ' . $message);
	}

}