<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Adeira\Connector\GraphQL;
use Nette\Utils\Json;

class LandingEndpoint extends \Nette\Application\UI\Presenter
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

	public function renderDefault()
	{
		$this->template->introspection = Json::encode(\GraphQL\GraphQL::execute(
			$this->schemaFactory->build(),
			\GraphQL\Type\Introspection::getIntrospectionQuery(TRUE)
		), Json::PRETTY);
	}

}
