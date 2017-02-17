<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Endpoints;

use Adeira\Connector\GraphQL\Infrastructure\Delivery\Http\Nette\GraphqlErrorResponse;
use Nette\Application\Responses\JsonResponse;
use Nette\Http\Response as HttpResponse;
use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/Runner.php';

/**
 * @testCase
 */
final class GraphqlEndpointTest extends \Adeira\Connector\Tests\TestCase
{

	use \Testbench\TCompiledContainer;

	public function setUp()
	{
		\Tracy\Debugger::$productionMode = TRUE;
	}

	public function testThat404Works()
	{
		$response = $this->performFatRequest('/', NULL);
		Assert::type(GraphqlErrorResponse::class, $response);
		Assert::same([
			'data' => NULL,
			'errors' => [['message' => 'No route for HTTP request.']],
		], (array)$response->getPayload());
		Assert::same(404, $response->getCode());
	}

	public function testThatRequestWithEmptyBodyReturnsError()
	{
		$response = $this->performFatRequest('/graphql', NULL);
		Assert::type(GraphqlErrorResponse::class, $response);
		Assert::same([
			'data' => NULL,
			'errors' => [['message' => 'Recieved POST body empty. Please send me valid JSON.']],
		], (array)$response->getPayload());
		Assert::same(422, $response->getCode());
	}

	public function testThatRequestInvalidJsonReturnsError()
	{
		$response = $this->performFatRequest('/graphql', NULL, '{"invalidRawJson":');
		Assert::type(GraphqlErrorResponse::class, $response);
		Assert::same([
			'data' => NULL,
			'errors' => [['message' => 'Recieved POST body is not in valid JSON format.']],
		], (array)$response->getPayload());
		Assert::same(422, $response->getCode());
	}

	public function testThatValidJsonWithoutQueryReturnsError()
	{
		$response = $this->performFatRequest('/graphql', NULL, '{"key":"value"}');
		Assert::type(GraphqlErrorResponse::class, $response);
		Assert::same([
			'data' => NULL,
			'errors' => [['message' => "Request mush have 'query' field with GraphQL query."]],
		], (array)$response->getPayload());
		Assert::same(422, $response->getCode());
	}

	public function testThatGraphqlSyntaxErrorReturnsError()
	{
		$response = $this->performFatRequest('/graphql', '{user');
		Assert::type(JsonResponse::class, $response);
		Assert::same([
			'errors' => [
				[
					'message' => "Syntax Error GraphQL request (1:6) Expected Name, found <EOF>\n\n1: {user\n        ^\n",
					'locations' => [['line' => 1, 'column' => 6]],
				],
			],
		], (array)$response->getPayload());
		$httpResponse = $this->getService(HttpResponse::class);
		Assert::same(422, $httpResponse->getCode());
	}

	public function testThatGraphqlValidationErrorReturnsError()
	{
		$response = $this->performFatRequest('/graphql', '{user}');
		Assert::type(JsonResponse::class, $response);
		Assert::same([
			'errors' => [
				[
					'message' => 'Argument "id" of required type "ID!" was not provided.',
					'locations' => [['line' => 1, 'column' => 2]],
				],
			],
		], (array)$response->getPayload());
		$httpResponse = $this->getService(HttpResponse::class);
		Assert::same(422, $httpResponse->getCode());
	}

	public function testThatAllGraphqlEndpointAreAvailable()
	{
		$response = $this->performFatRequest('/graphql', '{__type(name:"Query"){fields{name}}}'); //introspection
		Assert::type(JsonResponse::class, $response);
		Assert::same([
			'data' => [
				'__type' => [
					'fields' => [
						['name' => 'user'],
						['name' => 'allWeatherStations'],
						['name' => 'weatherStation'],
						['name' => 'test'],
					],
				],
			],
		], (array)$response->getPayload());
		$httpResponse = $this->getService(HttpResponse::class);
		Assert::same(200, $httpResponse->getCode());
	}

	public function testThatSuccessEndpointWorks()
	{
		$response = $this->performFatRequest('/graphql', '{test{success}}');
		Assert::type(JsonResponse::class, $response);
		Assert::same([
			'data' => [
				'test' => ['success' => '00000000-0000-0000-0000-000000000000'],
			],
		], (array)$response->getPayload());
		$httpResponse = $this->getService(HttpResponse::class);
		Assert::same(200, $httpResponse->getCode());
	}

	public function testThatInternalExceptionReturnsServerError()
	{
		$doRequest = function (string $errorMessage) {
			$response = $this->performFatRequest('/graphql', '{test{exception}}');
			Assert::type(JsonResponse::class, $response);
			Assert::same([
				'data' => NULL,
				'errors' => [
					['message' => $errorMessage],
				],
			], (array)$response->getPayload());
			$httpResponse = $this->getService(HttpResponse::class);
			Assert::same(500, $httpResponse->getCode());
		};

		$doRequest('Internal Server Error.');
		\Tracy\Debugger::$productionMode = FALSE; //localhost
		$doRequest('Internal exception message with sensitive data.');
	}

	private function performFatRequest($path = '/', ?string $query, ?string $rawJson = NULL): ?JsonResponse
	{
		return (new Runner)->performFatRequest($path, $query, $rawJson);
	}

}

(new GraphqlEndpointTest)->run();
