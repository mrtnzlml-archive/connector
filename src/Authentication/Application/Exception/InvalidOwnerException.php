<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Application\Exception;

final class InvalidOwnerException extends \Adeira\Connector\Endpoints\Application\Exceptions\BubbleUpGracefullyException
{

	public function __construct(string $message = NULL)
	{
		parent::__construct('Owner is not valid or it doesn\'t have enough permissions. ' . $message);
	}

}
