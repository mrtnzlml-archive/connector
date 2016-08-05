<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette;
use Nette\Application\Responses;

class ErrorPresenter implements Nette\Application\IPresenter
{

	use Nette\SmartObject;

	private $logger;

	public function __construct(\Tracy\ILogger $logger)
	{
		$this->logger = $logger;
	}

	public function run(Nette\Application\Request $request): Nette\Application\IResponse
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof Nette\Application\BadRequestException) {
			return new Responses\ForwardResponse($request->setPresenterName('Error4xx'));
		}

		$this->logger->log($exception, \Tracy\ILogger::EXCEPTION);
		return new Responses\CallbackResponse(function () {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}

}
