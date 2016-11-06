<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Adeira\Api\JsonResponsePretty;
use Adeira\Connector\GraphQL;

class GraphqlEndpoint extends \Nette\Application\UI\Presenter
{

	/**
	 * @var \Adeira\Connector\GraphQL\SchemaFactory
	 */
	private $schemaFactory;

	public function __construct(GraphQL\SchemaFactory $schemaFactory)
	{
		parent::__construct();
		$this->schemaFactory = $schemaFactory;
	}

	public function actionDefault($query = NULL)
	{
		$httpRequest = $this->getHttpRequest();
		if ($httpRequest->isMethod('POST')) {
			$query = $this->getHttpRequest()->getRawBody();
		} elseif ($query === NULL) {
			$this->sendJson(['Empty query.']);
		}
		$this->sendResponse(new JsonResponsePretty(\GraphQL\GraphQL::execute(
			$this->schemaFactory->build(),
			$query
		)));
	}

}
