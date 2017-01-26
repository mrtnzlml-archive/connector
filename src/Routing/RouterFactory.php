<?php declare(strict_types = 1);

namespace Adeira\Connector\Routing;

use Nette\Application\Routers\{
	Route, RouteList
};

final class RouterFactory
{

	public static function createRouter(): RouteList
	{
		$router = new RouteList();
		$router[] = new Route('graphql', 'Graphql:default');
		return $router;
	}

}
