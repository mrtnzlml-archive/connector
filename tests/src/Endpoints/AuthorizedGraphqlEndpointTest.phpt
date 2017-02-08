<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Endpoints;

use Nette\Application\Responses\JsonResponse;
use Nette\Http\Response as HttpResponse;
use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/Runner.php';

/**
 * @testCase
 */
final class AuthorizedGraphqlEndpointTest extends \Adeira\Connector\Tests\TestCase
{

	use \Testbench\TCompiledContainer;

	public function setUp()
	{
		\Tracy\Debugger::$productionMode = TRUE;
	}

	public function testThatBubbleUpGracefullyExceptionWorks()
	{
		$response = $this->performFatRequest('/graphql', '{allWeatherStations{weatherStations{id}}}');
		Assert::type(JsonResponse::class, $response);
		Assert::same([
			'data' => NULL,
			'errors' => [
				[
					'message' => 'Owner is not valid or it doesn\'t have enough permissions.',
				],
			],
		], (array)$response->getPayload());
		$httpResponse = $this->getService(HttpResponse::class);
		Assert::same(401, $httpResponse->getCode());
	}

	public function testThatInvalidJwtThrowsException()
	{
		$response = $this->performFatRequest('/graphql', '{allWeatherStations{weatherStations{id}}}', NULL, [
			'authorization' => 'token',
		]);
		Assert::type(JsonResponse::class, $response);
		Assert::same([
			'data' => NULL,
			'errors' => [
				[
					'message' => 'Provided JWT token is not valid: wrong number of segments',
				],
			],
		], (array)$response->getPayload());
		$httpResponse = $this->getService(HttpResponse::class);
		Assert::same(401, $httpResponse->getCode());
	}

	private function performFatRequest($path = '/', ?string $query, ?string $rawJson = NULL, $headers = NULL): ?JsonResponse
	{
		return (new Runner)->performFatRequest($path, $query, $rawJson, $headers);
	}

}

(new AuthorizedGraphqlEndpointTest)->run();
