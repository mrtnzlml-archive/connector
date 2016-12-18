<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service\DataSource;

use Adeira\Connector\Identity\DomainModel\User\IOwnerService;
use Adeira\Connector\Identity\DomainModel\User\UserId;
use Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository;

class ViewAllDataSourcesService
{

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository
	 */
	private $dataSourceRepository;

	/**
	 * @var \Adeira\Connector\Identity\DomainModel\User\IOwnerService
	 */
	private $ownerService;

	public function __construct(IDataSourceRepository $dataSourceRepository, IOwnerService $ownerService)
	{
		$this->dataSourceRepository = $dataSourceRepository;
		$this->ownerService = $ownerService;
	}

	public function execute(UserId $userId)
	{
		$owner = $this->ownerService->ownerFrom($userId);
		if ($owner === NULL) {
			$this->ownerService->throwInvalidOwnerException();
		}

		return $this->dataSourceRepository->all($userId);
	}

}
