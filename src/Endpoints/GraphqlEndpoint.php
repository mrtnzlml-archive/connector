<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Adeira\Api\JsonResponsePretty;
use GraphQL;

class GraphqlEndpoint extends \Nette\Application\UI\Presenter
{

	public function actionDefault($query = NULL)
	{
		$httpRequest = $this->getHttpRequest();
		if ($httpRequest->isMethod('POST')) {
			$query = $this->getHttpRequest()->getRawBody();
		} elseif ($query === NULL) {
			$this->sendJson(['Empty query.']);
		}
		$this->sendResponse(new JsonResponsePretty(GraphQL\GraphQL::execute(
			GraphqlSchemaFactory::build(),
			$query
		)));
	}

}
