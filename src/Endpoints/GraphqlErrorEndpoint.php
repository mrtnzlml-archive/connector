<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Nette;

class GraphqlErrorEndpoint implements \Nette\Application\IPresenter
{

	/**
	 * @var \Tracy\ILogger
	 */
	private $logger;

	public function __construct(\Tracy\ILogger $logger)
	{
		$this->logger = $logger;
	}

	public function run(Nette\Application\Request $request): Nette\Application\IResponse
	{
		$exc = $request->getParameter('exception');
		if ($exc instanceof \Nette\Application\BadRequestException) {
			$message = 'No route for HTTP request.';
		} else {
			$message = 'Internal Server Error.';
			$this->logger->log($exc, \Tracy\ILogger::EXCEPTION);
		}

		$payload = new \stdClass;
		$payload->data = NULL;
		$payload->errors = [
			['message' => $message],
		];
		return new \Adeira\Api\JsonResponsePretty($payload);
	}

}
