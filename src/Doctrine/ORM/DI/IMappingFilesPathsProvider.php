<?php declare(strict_types = 1);

namespace Adeira\Connector\Doctrine\ORM\DI;

interface IMappingFilesPathsProvider
{

	public function getMappingFilesPaths(): array;

}
