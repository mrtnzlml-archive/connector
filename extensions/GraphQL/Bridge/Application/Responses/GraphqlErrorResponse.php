<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Bridge\Application\Responses;

use Nette;
use Nette\Http;

class GraphqlErrorResponse extends \Nette\Application\Responses\JsonResponse
{

	/**
	 * @var int
	 */
	private $code;

	public function __construct(string $errorMessage, int $code = Http\IResponse::S500_INTERNAL_SERVER_ERROR)
	{
		$this->code = $code;
		$payload = new \stdClass;
		$payload->data = NULL;
		$payload->errors = [
			['message' => $errorMessage],
		];
		parent::__construct($payload, NULL);
	}

	/**
	 * Sends response to output.
	 * @return void
	 */
	public function send(Nette\Http\IRequest $httpRequest, Nette\Http\IResponse $httpResponse)
	{
		$httpResponse->setCode($this->code);
		parent::send($httpRequest, $httpResponse);
	}

}
