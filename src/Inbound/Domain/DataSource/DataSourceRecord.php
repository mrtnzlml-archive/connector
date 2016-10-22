<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Domain\DataSource;

use Adeira\Connector\Common\UuidProvider;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="data_source_records")
 */
class DataSourceRecord
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary")
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @var \Ramsey\Uuid\Uuid
	 */
	private $uuid;

	/**
	 * @ORM\ManyToOne(targetEntity="DataSource", inversedBy="dataSourceRecords", cascade={"persist"})
	 * @ORM\JoinColumn(name="data_source_id", referencedColumnName="uuid")
	 * @var DataSource
	 */
	private $dataSource;

	/**
	 * @ORM\Column(type="jsonb")
	 */
	private $jsonb;

	public function __construct()
	{
		$this->id = UuidProvider::provide();
	}

	public function __clone()
	{
		$this->id = UuidProvider::provide();
	}

}
