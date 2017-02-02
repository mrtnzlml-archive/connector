<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Endpoints;

use Adeira\Connector\GraphQL\Bridge\Application\Responses\GraphqlErrorResponse;
use Nette\Application\Application;
use Nette\Application\IResponse;
use Nette\Application\Responses\JsonResponse;
use Nette\Http\Response as HttpResponse;
use Nette\Http\UrlScript;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class GraphqlEndpointTest extends \Adeira\Connector\Tests\TestCase
{

	use \Testbench\TCompiledContainer;

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
			'errors' => [['message' => 'Recieved POST body empty.']],
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

	public function testThatGraphqlEndpointWorks()
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
					],
				],
			],
		], (array)$response->getPayload());
		$httpResponse = $this->getService(HttpResponse::class);
		Assert::same(200, $httpResponse->getCode());
	}

	private function performFatRequest($path = '/', ?string $query, ?string $rawJson = NULL): ?JsonResponse
	{
		$container = $this->getContainer();
		$container->addService('httpRequest', new \Nette\Http\Request(
			new UrlScript("//x.y.$path"),
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			'POST',
			NULL,
			NULL,
			function () use ($query, $rawJson) {
				if($rawJson !== NULL) {
					return $rawJson;
				}
				if ($query === NULL) {
					return NULL;
				}
				return json_encode((object)[
					'query' => $query,
				]);
			}
		));
		/** @var Application $application */
		$application = $this->getService(Application::class);
		$returnedResponse = NULL;
		$application->onResponse[] = function (Application $sender, IResponse $response) use (&$returnedResponse) {
			Assert::type(JsonResponse::class, $response);
			$returnedResponse = $response;
		};
		ob_start();
		$application->run();
		ob_end_clean();
		return $returnedResponse;
	}

}

(new GraphqlEndpointTest)->run();
