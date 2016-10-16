<?php declare(strict_types = 1);

namespace Adeira\Connector\Router;

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
		//TODO: optimized REST route
		$router[] = new Route('webcomponent/<action>', 'Webcomponents:');
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
