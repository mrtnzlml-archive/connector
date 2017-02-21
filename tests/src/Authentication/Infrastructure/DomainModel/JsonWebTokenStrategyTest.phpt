<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Authentication\Infrastructure\DomainModel;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Authentication\Infrastructure\DomainModel\JsonWebTokenStrategy;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class JsonWebTokenStrategyTest extends \Tester\TestCase
{

	public function testThatGenerateTokenWorks()
	{
		$jwts = new JsonWebTokenStrategy('token', 1);
		$generatedToken = $jwts->generateNewToken(UserId::createFromString('00000000-0000-0000-0000-100000000000'));

		$payload = (array)$jwts->decodeToken($generatedToken);
		Assert::same(['iat', 'exp', 'uuid'], array_keys($payload));
		Assert::same('00000000-0000-0000-0000-100000000000', $payload['uuid']);
	}

}

(new JsonWebTokenStrategyTest)->run();
