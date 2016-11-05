<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Inbound\DomainModel;
use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecord;
use Adeira\Connector\Inbound\DomainModel\DataSourceRecord\DataSourceRecordId;
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
class DoctrineDataSourceRecordRepository implements DomainModel\DataSourceRecord\IDataSourceRecordRepository
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function add(DataSourceRecord $aDataSourceRecord)
	{
		$this->em->persist($aDataSourceRecord);
	}

	public function ofId(DataSourceRecordId $dataSourceRecordId)
	{
		// TODO: Implement ofId() method.
	}

	public function ofDataSourceId(DataSourceId $dataSourceId)
	{
		// TODO: Implement ofDataSourceId() method.
	}

	public function nextIdentity(): DataSourceRecordId
	{
		return DomainModel\DataSourceRecord\DataSourceRecordId::create();
	}

}
