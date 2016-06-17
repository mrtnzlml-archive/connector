<?hh

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter(): Nette\Application\Routers\SimpleRouter
	{
		// $router = new RouteList();
		// $router[] = new Route('served/app', 'Served:app');
		// $router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		$router = new Nette\Application\Routers\SimpleRouter('Homepage:default'); //FIXME
		return $router;
	}

}
