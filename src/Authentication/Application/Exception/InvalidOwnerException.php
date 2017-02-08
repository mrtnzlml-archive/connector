<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Application\Exception;

use Nette\Http\IResponse;

final class InvalidOwnerException extends \Adeira\Connector\Endpoints\Application\Exceptions\BubbleUpGracefullyException
{

	public function __construct()
	{
		parent::__construct('Owner is not valid or it doesn\'t have enough permissions.', IResponse::S401_UNAUTHORIZED);
	}

}
