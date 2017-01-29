<?php declare(strict_types = 1);

namespace Adeira\Connector\Routing;

use Nette\Application\IRouter;
use Nette\Application\Request as AppRequest;
use Nette\Http;

final class Router implements IRouter
{

	public function match(Http\IRequest $httpRequest) {
		$url = $httpRequest->getUrl();
		$path = $url->getPath();
		if ($path !== '/graphql') {
			return NULL;
		}

		return new AppRequest(
			'Graphql'
		);
	}

	public function constructUrl(AppRequest $appRequest, Http\Url $refUrl) {
		return NULL; // ONE_WAY by default
	}

}
