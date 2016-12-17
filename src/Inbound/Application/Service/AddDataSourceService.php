<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service;

use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Adeira\Connector\Inbound\DomainModel;

/**
 * Application services should depend on abstraction (interfaces) so we'll make our Application Service immune to
 * low-level Infrastructure changes. It's important to keep your Application Services setup out of the Infrastructure
 * boundary. Also those services should be registered in DIC.
 */
class AddDataSourceService
{

	use \Nette\SmartObject;

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository
	 */
	private $dataSourceRepository;

	/**
	 * @var \Adeira\Connector\Common\Application\Service\ITransactionalSession
	 */
	private $transactionalSession;

	public function __construct(
		DomainModel\DataSource\IDataSourceRepository $dataSourceRepository,
		ITransactionalSession $transactionalSession
	) {
		$this->dataSourceRepository = $dataSourceRepository;
		$this->transactionalSession = $transactionalSession;
	}

	/**
	 * AddDataSourceRequest should be simple DTO filled by form in presenter.
	 */
	public function execute(AddDataSourceRequest $request): AddDataSourceResponse
	{
		return $this->transactionalSession->executeAtomically(function () use ($request) {
			$this->dataSourceRepository->add($dataSource = new DomainModel\DataSource\DataSource(
				$this->dataSourceRepository->nextIdentity(),
				$request->name()
			));

			//instead of manual DTO creation it's better to use DTO assembler:
			//return $this->dataSourceDtoAssembler->assemble($dataSource);
			return new AddDataSourceResponse($dataSource->id()); // it's returned to the controller!
		});
	}

}
