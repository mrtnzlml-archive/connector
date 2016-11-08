<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Nette\Application as NApplication;
use Tracy\ILogger;

class GraphqlErrorEndpoint implements NApplication\IPresenter
{

	/**
	 * @var \Tracy\ILogger
	 */
	private $logger;

	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}

	public function run(NApplication\Request $request): NApplication\IResponse
	{
		$exc = $request->getParameter('exception');
		if ($exc instanceof \Nette\Application\BadRequestException) {
			$message = 'No route for HTTP request.';
		} else {
			$message = 'Internal Server Error.';
			$this->logger->log($exc, ILogger::EXCEPTION);
		}

		$payload = new \stdClass;
		$payload->data = NULL;
		$payload->errors = [
			['message' => $message],
		];
		return new NApplication\Responses\JsonResponse($payload);
	}

}
