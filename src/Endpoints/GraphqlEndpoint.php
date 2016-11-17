<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Adeira\Connector\GraphQL;
use Nette\Utils\Json;

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
		$requestString = $query;
		$variableValues = NULL;

		$httpRequest = $this->getHttpRequest();
		if ($httpRequest->isMethod('POST')) {
			// http://graphql.org/learn/serving-over-http/#post-request
			$queryData = Json::decode($this->getHttpRequest()->getRawBody(), Json::FORCE_ARRAY);
			$requestString = $queryData['query'];
			$variableValues = $queryData['variables'];
		} elseif ($query === NULL) {
			$this->sendJson(['Empty query.']);
		}
		$this->sendJson(\GraphQL\GraphQL::execute(
			$this->schemaFactory->build(),
			$requestString,
			NULL,
			$this->getUser(),
			$variableValues
		));
	}

}
