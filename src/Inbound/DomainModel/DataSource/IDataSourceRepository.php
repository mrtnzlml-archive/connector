<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

interface IDataSourceRepository
{

	public function add(DataSource $aDataSource);

//	public function addAll(array $dataSources);

//	public function remove(DataSource $aDataSource);

//	public function removeAll(array $dataSources);

	public function nextIdentity(): DataSourceId;

}
