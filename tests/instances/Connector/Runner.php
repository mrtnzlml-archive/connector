<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests;

use Nette\Application\Application;
use Nette\Application\IResponse;
use Nette\Application\Responses\JsonResponse;
use Nette\Http\UrlScript;
use Tester\Assert;

final class Runner
{

	use \Testbench\TCompiledContainer;

	public function performFatRequest($path = '/', ?string $query, ?string $rawJson = NULL, $headers = NULL): ?JsonResponse
	{
		$container = $this->getContainer();
		$container->removeService('httpRequest');
		$container->addService('httpRequest', new \Nette\Http\Request(
			new UrlScript("//x.y.$path"),
			NULL,
			NULL,
			NULL,
			NULL,
			$headers,
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
