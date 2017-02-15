<?php declare(strict_types = 1);

namespace Adeira\Connector\ServiceBus\Infrastructure\DomainModel;

use Adeira\Connector\Common\Application\Service\ITransactionalSession;
use Adeira\Connector\ServiceBus\DomainModel\ICommand;

class TransactionalCommandBus extends CommandBus
{

	private $transactionalSession;

	/**
	 * @param array $dispatchMap [(string)command => callable]
	 */
	public function __construct(ITransactionalSession $transactionalSession, array $dispatchMap)
	{
		$this->transactionalSession = $transactionalSession;
		parent::__construct($dispatchMap);
	}

	public function dispatch(ICommand $aCommand): void
	{
		$this->transactionalSession->executeAtomically(function() use ($aCommand) {
			parent::dispatch($aCommand);
		});
	}

}
