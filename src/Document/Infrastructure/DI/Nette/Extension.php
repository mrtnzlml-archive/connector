<?php declare(strict_types = 1);

namespace Adeira\Connector\Document\Infrastructure\DI\Nette;

use Adeira\Connector\Doctrine\ORM;

final class Extension extends \Adeira\CompilerExtension implements ORM\DI\IMappingFilesPathsProvider
{

	public function getMappingFilesPaths(): array
	{
		return [__DIR__ . '/../../Persistence/Doctrine/Mapping'];
	}

}
