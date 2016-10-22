<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Domain\DataSource;

use Adeira\Connector\Common\UuidProvider;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="data_sources")
 */
class DataSource
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary")
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @var \Ramsey\Uuid\Uuid
	 */
	private $uuid;

	/**
	 * @ORM\OneToMany(targetEntity="DataSourceRecord", mappedBy="dataSource", cascade={"persist"})
	 * @var DataSourceRecord[]|\Doctrine\Common\Collections\ArrayCollection
	 */
	private $dataSourceRecords;

	public function __construct()
	{
		$this->id = UuidProvider::provide();
	}

	public function __clone()
	{
		$this->id = UuidProvider::provide();
	}

}
