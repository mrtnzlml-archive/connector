<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use GraphQL;
use Nette\Utils\Json;

class LandingEndpoint extends \Nette\Application\UI\Presenter
{

	public function renderDefault()
	{
		$this->template->introspection = Json::encode(GraphQL\GraphQL::execute(
			GraphqlSchemaFactory::build(),
			GraphQL\Type\Introspection::getIntrospectionQuery(TRUE)
		), Json::PRETTY);
	}

}
