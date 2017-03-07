<?php declare(strict_types = 1);

namespace Adeira\Connector\Application\Exceptions;

use Nette\Http\IResponse;

class BubbleUpGracefullyException extends \Exception
{

	public function __construct(string $message = '', ?int $code = NULL, ?\Throwable $previous = NULL)
	{
		$code = $code ?? IResponse::S422_UNPROCESSABLE_ENTITY;
		parent::__construct($message, $code, $previous);
	}

}
