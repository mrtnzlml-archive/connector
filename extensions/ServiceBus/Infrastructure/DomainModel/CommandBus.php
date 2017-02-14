<?php declare(strict_types = 1);

namespace Adeira\Connector\ServiceBus\Infrastructure\DomainModel;

use Adeira\Connector\ServiceBus\DomainModel\{
	ICommand, ICommandBus
};

class CommandBus implements ICommandBus
{

	private $dispatchMap = [];

	/**
	 * @param array $dispatchMap [(string)command => callable]
	 */
	public function __construct(array $dispatchMap)
	{
		$this->dispatchMap = $dispatchMap;
	}

	public function dispatch(ICommand $aCommand): void
	{
		$commandClassName = get_class($aCommand);
		if (array_key_exists($commandClassName, $this->dispatchMap)) {
			$this->dispatchMap[$commandClassName]($aCommand);
		}
	}

}
