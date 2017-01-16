<?php declare(strict_types = 1);

namespace Adeira\Connector\CompilerExtension;

class ConfigurableExtensionsExtension extends \Adeira\ConfigurableExtensionsExtension
{

	public function loadFromFile($file)
	{
		$loader = new \Nette\DI\Config\Loader;
		$loader->addAdapter('neon', \Adeira\Connector\CompilerExtension\NeonAdapter::class);
		$res = $loader->load($file);
		$this->compiler->addDependencies($loader->getDependencies());
		return $res;
	}

}
