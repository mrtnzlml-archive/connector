<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette;

final class QueryResolver
{

	public function __invoke()
	{
		return __METHOD__;
	}

}
