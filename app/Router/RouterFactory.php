<?hh

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

class RouterFactory
{
	use Nette\SmartObject;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter(): RouteList
	{
		$router = new RouteList();
		$router[] = new Route('webcomponent/<action>', 'Webcomponents:');
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}

}
