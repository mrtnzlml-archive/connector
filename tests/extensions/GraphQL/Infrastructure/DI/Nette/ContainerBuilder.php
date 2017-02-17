<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette;

use Nette;

final class ContainerBuilder
{

	public static function createContainer(string $configFilePath = NULL, array $params = []): Nette\DI\Container
	{
		$compiler = new Nette\DI\Compiler;
		$compiler->addExtension('graphql', new \Adeira\Connector\GraphQL\Infrastructure\DI\Nette\Extension);
		$class = 'Container' . md5((string)lcg_value());

		$loader = new Nette\DI\Config\Loader;
		$config = $loader->load($configFilePath);

		$code = $compiler->addConfig((array)$config)
			->setClassName($class)
			->compile();

		$fileInfo = new \SplFileInfo($configFilePath);
		$outputFileName = "DIC_GraphQL_{$fileInfo->getFilename()}.php";
		$tempDir = \Testbench\Bootstrap::$tempDir;
		file_put_contents($tempDir . "/$outputFileName", "<?php\n\n$code");
		require $tempDir . "/$outputFileName";
		return new $class($params);
	}

}
