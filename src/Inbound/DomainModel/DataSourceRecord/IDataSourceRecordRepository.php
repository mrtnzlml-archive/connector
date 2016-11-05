<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSourceRecord;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;

interface IDataSourceRecordRepository
{

	public function add(DataSourceRecord $aDataSourceRecord);

	public function ofId(DataSourceRecordId $dataSourceRecordId);

	public function ofDataSourceId(DataSourceId $dataSourceId);

	public function nextIdentity(): DataSourceRecordId;

}
