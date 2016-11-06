<?php declare(strict_types = 1);

namespace Adeira\Connector\Routing;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

class RouterFactory
{

	use Nette\SmartObject;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter(): RouteList
	{
		$router = new RouteList();
		$router[] = new Route('', 'Landing:default');
		$router[] = new Route('graphql', 'Graphql:default'); // GET: /graphql?query={device(id:"58d200ad-6376-4c01-9b6d-2ea536f1cd2c"){id,name,records(first:1)}}
		return $router;
	}

}
