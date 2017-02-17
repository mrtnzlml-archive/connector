<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette;

use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/ContainerBuilder.php';

/**
 * @testCase
 */
final class ExtensionTest extends \Adeira\Connector\Tests\TestCase
{

	public function testEmpty()
	{
		Assert::noError(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/empty.neon');
		});
	}

}

(new ExtensionTest)->run();
