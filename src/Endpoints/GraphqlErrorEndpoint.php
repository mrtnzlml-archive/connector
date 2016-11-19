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
			$message = $exc->getMessage();
		} else {
			$message = \Tracy\Debugger::$productionMode ? 'Internal Server Error.' : $exc->getMessage();
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
