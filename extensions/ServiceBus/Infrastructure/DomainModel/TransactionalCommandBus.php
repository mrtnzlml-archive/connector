<?php declare(strict_types = 1);

namespace Adeira\Connector\ServiceBus\Infrastructure\DomainModel;

use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Adeira\Connector\ServiceBus\DomainModel\{
	ICommand, ICommandBus
};

class TransactionalCommandBus implements ICommandBus
{

	private $dispatchMap = [];

	private $transactionalSession;

	/**
	 * @param array $dispatchMap [(string)command => callable]
	 */
	public function __construct(ITransactionalSession $transactionalSession, array $dispatchMap)
	{
		$this->transactionalSession = $transactionalSession;
		$this->dispatchMap = $dispatchMap;
	}

	public function dispatch(ICommand $aCommand): void
	{
		$commandClassName = get_class($aCommand);
		if (array_key_exists($commandClassName, $this->dispatchMap)) {
			$this->transactionalSession->executeAtomically(function() use ($commandClassName, $aCommand) {
				$this->dispatchMap[$commandClassName]($aCommand);
			});
		}
	}

}
