<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DI\Nette;

use Adeira\Connector\Doctrine\ORM;

class Extension extends \Adeira\CompilerExtension implements ORM\DI\IMappingFilesPathsProvider
{

	public function provideConfig(): string
	{
		return __DIR__ . '/config.neon';
	}

	public function getMappingFilesPaths(): array
	{
		return [__DIR__ . '/../../Persistence/Doctrine/Mapping'];
	}

}
