<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Routing;

use Nette\Application\IRouter;
use Nette\Http\Request;
use Nette\Http\UrlScript;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class RouterFactoryTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatRouterIsInstanceOfIRouter()
	{
		$router = new \Adeira\Connector\Routing\Router;
		Assert::type(IRouter::class, $router);
	}

	public function testThatMatchMethodWorks()
	{
		$router = new \Adeira\Connector\Routing\Router;
		Assert::same('Connector:Graphql', ($router->match(new Request(
			new UrlScript('//x.y/graphql')
		)))->getPresenterName());

		Assert::null($router->match(new Request(
			new UrlScript('//x.y/')
		)));
		Assert::null($router->match(new Request(
			new UrlScript('//x.y/nonsense')
		)));
	}

	public function testThatConstructUrlReturnsNull()
	{
		$router = new \Adeira\Connector\Routing\Router;
		Assert::null($router->constructUrl(
			new \Nette\Application\Request('Connector:Graphql'),
			new UrlScript('//x.y/')
		));
	}

}

(new RouterFactoryTest)->run();
