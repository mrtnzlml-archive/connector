<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints\Infrastructure\Delivery\Http;

use Adeira\Connector\GraphQL\Bridge\Application\Responses\GraphqlErrorResponse;
use Nette\Application as NApplication;
use Nette\Http\IResponse;
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
		/** @var \Exception $exc */
		$exc = $request->getParameter('exception');

		if ($exc instanceof \Nette\Application\BadRequestException) {

			$messages = $exc->getMessage();
			$code = IResponse::S404_NOT_FOUND;
			return new GraphqlErrorResponse($messages, $code);

		} elseif ($exc instanceof \GraphQL\Executor\ExecutionResult) {

			$messages = [];
			/** @var \GraphQL\Error\Error $error */
			foreach ($exc->errors as $error) {
				if ($error->getPrevious() === NULL) {
					$messages[] = $error;
				} else {
					return $this->internalServerError($error->getPrevious());
				}
			}
			$code = IResponse::S422_UNPROCESSABLE_ENTITY;
			return new GraphqlErrorResponse($messages, $code, FALSE);

		} else {

			return $this->internalServerError($exc);

		}
	}

	private function internalServerError(\Throwable $exc)
	{
		$messages = \Tracy\Debugger::$productionMode ? 'Internal Server Error.' : $exc->getMessage();
		$code = IResponse::S500_INTERNAL_SERVER_ERROR;
		$this->logger->log($exc, ILogger::EXCEPTION);
		return new GraphqlErrorResponse($messages, $code);
	}

}
