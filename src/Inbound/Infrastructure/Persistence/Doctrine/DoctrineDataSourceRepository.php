<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Inbound\DomainModel;
use Adeira\Connector\Inbound\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
class DoctrineDataSourceRepository implements DomainModel\DataSource\IDataSourceRepository
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function add(DomainModel\DataSource\DataSource $aDataSource)
	{
		$this->em->persist($aDataSource);
	}

	public function nextIdentity(): DomainModel\DataSource\IDataSourceId
	{
		//FIXME: mělo by to být takto zde bez možnosti změny implementace?
		return Infrastructure\DomainModel\DataSource\UuidDataSourceId::create();
	}

}
