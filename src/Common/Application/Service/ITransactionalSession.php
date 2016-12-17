<?php declare(strict_types = 1);

namespace Adeira\Connector\Common\Application\Service;

interface ITransactionalSession
{

	/**
	 * @param  callable $operation
	 *
	 * @return mixed
	 */
	public function executeAtomically(callable $operation);

}
