<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\Application\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DoctrineSession
 * @package Ddd\Infrastructure\Application\Service
 */
final class DoctrineSession implements \Adeira\Connector\Common\Application\Service\ITransactionalSession
{

	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return mixed
	 */
	public function executeAtomically(callable $operation)
	{
		return $this->entityManager->transactional($operation);
	}

}
