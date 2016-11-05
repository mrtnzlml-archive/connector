<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Service;

use Adeira\Connector\Inbound\DomainModel;
use Doctrine\ORM\EntityManagerInterface;

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
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(
		DomainModel\DataSource\IDataSourceRepository $dataSourceRepository,
		EntityManagerInterface $em
	) {
		$this->dataSourceRepository = $dataSourceRepository;
		$this->em = $em;
	}

	/**
	 * AddDataSourceRequest should be simple DTO filled by form in presenter.
	 */
	public function execute(AddDataSourceRequest $request): AddDataSourceResponse
	{
		$this->dataSourceRepository->add($dataSource = new DomainModel\DataSource\DataSource(
			$this->dataSourceRepository->nextIdentity(),
			$request->name()
		));

		$this->em->flush();// FIXME: this is maybe weird?
		return new AddDataSourceResponse($dataSource->id()); // it's returned to the controller!

		//instead of manual DTO creation it's better to use DTO assembler:
		//return $this->dataSourceDtoAssembler->assemble($dataSource);
	}

}
