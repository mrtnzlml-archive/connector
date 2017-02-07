<?php declare(strict_types = 1);

namespace Adeira\Connector\ServiceBus\DomainModel;

interface ICommandBus
{

	public function dispatch(ICommand $command);

}
