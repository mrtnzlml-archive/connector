<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Exception;

final class OverrideException extends \Exception
{

	public function __construct(string $originalClass, string $methodName)
	{
		parent::__construct(
			"You MUST override method '$methodName' in '$originalClass' because it's required."
		);
	}

}
