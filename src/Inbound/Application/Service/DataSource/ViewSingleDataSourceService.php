<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service\DataSource;

use Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository;

class ViewSingleDataSourceService
{

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository
	 */
	private $dataSourceRepository;

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\Owner\IOwnerService
	 */
	private $ownerService;

	public function __construct(IDataSourceRepository $dataSourceRepository, IOwnerService $ownerService)
	{
		$this->dataSourceRepository = $dataSourceRepository;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId, DataSourceId $dataSourceId)
	{
		$owner = $this->ownerService->ownerFrom($userId);
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}

		return $this->dataSourceRepository->ofId($dataSourceId);
	}

}
