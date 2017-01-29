<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Routing;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class RouterFactoryTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatCreateRouterWorksAsExpected()
	{
		$routeList = (new \Adeira\Connector\Routing\RouterFactory)->createRouter();
		Assert::type(RouteList::class, $routeList);
		Assert::same('', $routeList->getModule());
		Assert::same(1, $routes = $routeList->getIterator()->count());
		Assert::type(Route::class, $route = $routeList[0]);
		Assert::same('graphql', $route->getMask());
		Assert::same([
			'presenter' => 'Graphql',
			'action' => 'default',
		], $route->getDefaults());
		Assert::same(0, $route->getFlags()); //default
	}

}

(new RouterFactoryTest)->run();
