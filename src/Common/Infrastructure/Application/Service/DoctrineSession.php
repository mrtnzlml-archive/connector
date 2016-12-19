<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\Application\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineSession
 * @package Ddd\Infrastructure\Application\Service
 */
class DoctrineSession implements \Adeira\Connector\Common\Application\Service\ITransactionalSession
{

	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function executeAtomically(callable $operation)
	{
		return $this->entityManager->transactional($operation);
	}

}
