<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Identity\Infrastructure\DomainModel;

use Adeira\Connector\Identity\Infrastructure\DomainModel\JsonWebTokenStrategy;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
class JsonWebTokenStrategyTest extends \Tester\TestCase
{

	public function testThatGenerateTokenWorks()
	{
		$jwts = new JsonWebTokenStrategy('token');
		$generatedToken = $jwts->generateNewToken();
		Assert::same(['iat', 'exp'], array_keys((array)$jwts->decodeToken($generatedToken)));

		$generatedToken = $jwts->generateNewToken(['payload' => 'value']);
		$payload = (array)$jwts->decodeToken($generatedToken);
		Assert::same(['iat', 'exp', 'payload'], array_keys($payload));
		Assert::same('value', $payload['payload']);
	}

}

(new JsonWebTokenStrategyTest)->run();
