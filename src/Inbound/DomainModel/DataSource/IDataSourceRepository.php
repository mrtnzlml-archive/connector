<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\DomainModel\DataSource;

use Adeira\Connector\Identity\DomainModel\User\UserId;

interface IDataSourceRepository
{

	public function add(DataSource $aDataSource);

//	public function addAll(array $dataSources);

	public function ofId(DataSourceId $dataSourceId);//: ?DataSource;

	public function all(UserId $userId);//: iterable;

//	public function remove(DataSource $aDataSource);

//	public function removeAll(array $dataSources);

	public function nextIdentity(): DataSourceId;

}
