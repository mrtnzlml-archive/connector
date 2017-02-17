<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\Delivery\API\GraphQL;

final class TestCase
{

	public function success()
	{
		return '00000000-0000-0000-0000-000000000000';
	}

	public function exception()
	{
		throw new \Exception('Internal exception message with sensitive data.');
	}

}
