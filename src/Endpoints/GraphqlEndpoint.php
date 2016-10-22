<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Adeira\Api\JsonResponsePretty;

class GraphqlEndpoint extends \Nette\Application\UI\Presenter
{

	public function actionDefault($query = NULL)
	{
		$httpRequest = $this->getHttpRequest();
		if ($httpRequest->isMethod('POST')) {
			$query = $this->getHttpRequest()->getRawBody();
		} else {
			$query = $query !== NULL ? $query : <<<GraphQL
{
	device(id: "1000") {
		id,
		name
	}
}
GraphQL;
		}
		$result = \GraphQL\GraphQL::execute(
			\Adeira\Connector\Endpoints\GraphqlSchemaFactory::build(),
			$query
		);
		$this->sendResponse(new JsonResponsePretty($result));
	}

}
