<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints\Infrastructure\Delivery\Http;

use Adeira\Connector\GraphQL\Bridge\Application\Responses\GraphqlErrorResponse;
use Nette\Application as NApplication;
use Tracy\ILogger;

final class GraphqlErrorEndpoint implements NApplication\IPresenter
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

		return new GraphqlErrorResponse($message);
	}

}
