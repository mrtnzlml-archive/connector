<?hh

namespace App\Presenters;

use Nette;
use Nette\Application\Responses;

class ErrorPresenter implements Nette\Application\IPresenter
{
	use Nette\SmartObject;

	public function __construct(private \Tracy\ILogger $logger) {}

	public function run(Nette\Application\Request $request): Responses\CallbackResponse
	{
		$exception = $request->getParameter('exception');

		if ($exception instanceof Nette\Application\BadRequestException) {
			return new Responses\ForwardResponse($request->setPresenterName('Error4xx'));
		}

		$this->logger->log($exception, ILogger::EXCEPTION);
		return new Responses\CallbackResponse(function () {
			require __DIR__ . '/templates/Error/500.phtml';
		});
	}

}
