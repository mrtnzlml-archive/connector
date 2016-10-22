<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Adeira\Api\JsonResponsePretty;
use Nette\Application\LinkGenerator;

class LandingEndpoint implements \Nette\Application\IPresenter
{

	/**
	 * @var \Nette\Application\LinkGenerator
	 */
	private $linkGenerator;

	public function __construct(LinkGenerator $linkGenerator)
	{
		$this->linkGenerator = $linkGenerator;
	}

	public function run(\Nette\Application\Request $request): JsonResponsePretty
	{
		return new JsonResponsePretty([
			$this->linkGenerator->link('Graphql:default'),
		]);
	}

}
