<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Inbound\DomainModel;
use Adeira\Connector\Inbound\DomainModel\DataSource\DataSource;
use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
class DoctrineDataSourceRepository /*extends ORM\EntityRepository*/ implements DomainModel\DataSource\IDataSourceRepository
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	/**
	 * @var \Doctrine\Common\Persistence\ObjectRepository
	 */
	private $dataSourceRepository;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
		$this->dataSourceRepository = $em->getRepository(DataSource::class);
	}

	public function add(DomainModel\DataSource\DataSource $aDataSource)
	{
		$this->em->persist($aDataSource);
	}

	public function ofId(DataSourceId $dataSourceId)//: ?DataSource
	{
		return $this->dataSourceRepository->findOneBy([
			'id' => $dataSourceId,
		]);
	}

	public function nextIdentity(): DomainModel\DataSource\DataSourceId
	{
		return DomainModel\DataSource\DataSourceId::create();
	}

}
