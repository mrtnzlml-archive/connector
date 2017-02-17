<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\GraphQL\Context;

final class TestQuery
{

	public function __invoke($ancestorValue, $args, Context $context)
	{
		return new TestCase;
	}

}
