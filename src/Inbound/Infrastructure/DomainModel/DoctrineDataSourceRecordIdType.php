<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\DomainModel;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DoctrineDataSourceRecordIdType extends \Adeira\Connector\Common\Infrastructure\DomainModel\DoctrineEntityId
{

	public function getTypeName(): string
	{
		return 'DataSourceRecordId'; //(DC2Type:DataSourceRecordId)
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): DataSourceId
	{
		$uuid = parent::convertToPHPValue($value, $platform);
		return DataSourceId::create($uuid);
	}

}
