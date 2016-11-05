<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\Bridge\Nette\DI;

use Adeira\Connector\Doctrine\ORM;

class Extension extends \Adeira\CompilerExtension implements ORM\DI\IMappingFilesPathsProvider
{

	public function loadConfiguration()
	{
		$this->addConfig(__DIR__ . '/config.neon');
	}

	public function getMappingFilesPaths(): array
	{
		return [__DIR__ . '/../../../Persistence/Doctrine/Mapping'];
	}

}
