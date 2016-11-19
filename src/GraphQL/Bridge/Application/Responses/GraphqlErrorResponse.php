<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Bridge\Application\Responses;

class GraphqlErrorResponse extends \Nette\Application\Responses\JsonResponse
{

	public function __construct($errorMessage)
	{
		$payload = new \stdClass;
		$payload->data = NULL;
		$payload->errors = [
			['message' => $errorMessage],
		];
		parent::__construct($payload, NULL);
	}

}
