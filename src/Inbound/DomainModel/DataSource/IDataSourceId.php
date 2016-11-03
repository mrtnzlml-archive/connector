<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

interface IDataSourceId
{

	public static function create($anId = NULL);

	public function __toString();

}
