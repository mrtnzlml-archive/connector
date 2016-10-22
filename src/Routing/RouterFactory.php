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
		$router[] = new Route('graphql', 'Graphql:default'); // GET: /graphql?query={device(id:"1000"){id,name}}
		return $router;
	}

}
