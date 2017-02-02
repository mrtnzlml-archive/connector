<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Bridge\Application\Responses;

use GraphQL\Language\SourceLocation;
use Nette;
use Nette\Http;

final class GraphqlErrorResponse extends \Nette\Application\Responses\JsonResponse
{

	/**
	 * @var int
	 */
	private $code;

	/**
	 * @param $errorMessage string|array
	 *
	 * @throws \Exception
	 * @throws \InvalidArgumentException
	 */
	public function __construct($errorMessage, int $code = Http\IResponse::S500_INTERNAL_SERVER_ERROR, $withDataField = TRUE)
	{
		$this->code = $code;
		$payload = new \stdClass;
		if ($withDataField) {
			$payload->data = NULL;
		}

		if(is_string($errorMessage)) {
			$payload->errors = [
				['message' => $errorMessage],
			];
		} else {
			foreach ($errorMessage as $error) {
				if (!$error instanceof \GraphQL\Error\Error) {
					$exceptionMessage = 'If you are sending array to the ' . __METHOD__ . ' it has to be array of ' . \GraphQL\Error\Error::class;
					throw new \InvalidArgumentException($exceptionMessage);
				}
				$payload->errors[] = [
					'message' => $error->getMessage(),
					'locations' => \GraphQL\Utils::map($error->getLocations(), function (SourceLocation $loc) {
						return $loc->toSerializableArray();
					}),
				];
			}
		}

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

	public function getCode(): int
	{
		return $this->code;
	}

}
