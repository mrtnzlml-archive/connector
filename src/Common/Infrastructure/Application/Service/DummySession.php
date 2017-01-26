<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Infrastructure\Application\Service;

final class DummySession implements \Adeira\Connector\Common\Application\Service\ITransactionalSession
{

	/**
	 * @return mixed
	 */
	public function executeAtomically(callable $operation)
	{
		return $operation();
	}

}
