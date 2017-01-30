<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Endpoints;

use Nette\Application\Responses\JsonResponse;
use Testbench\Mocks\ApplicationRequestMock;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class GraphqlEndpointTest extends \Adeira\Connector\Tests\TestCase
{

	use \Testbench\TCompiledContainer;
	use \Testbench\TPresenter;

	public function testThatGraphqlEndpointDoesntReturnError()
	{
		$presenterFactory = $this->getService(\Nette\Application\IPresenterFactory::class);
		$presenter = $presenterFactory->createPresenter('Connector:Graphql');
		$request = new ApplicationRequestMock(
			$presenter,
			'GET',
			['action' => 'default']
		);
		$response = $presenter->run($request);

		Assert::type(JsonResponse::class, $response);
		/** @var JsonResponse $response */
		$payload = $response->getPayload();
		Assert::true(array_key_exists('errors', (array)$payload));
		Assert::same([
			'message' => 'GET method is not allowed.',
		], ...$payload->errors);
	}

}

(new GraphqlEndpointTest)->run();
