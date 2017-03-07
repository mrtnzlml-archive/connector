<?php declare(strict_types = 1);

namespace Adeira\Connector\Infrastructure\DI\Nette;

final class Extension extends \Nette\DI\CompilerExtension
{

	public function provideConfig()
	{
		return __DIR__ . '/config.neon';
	}

}
