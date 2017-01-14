<?php declare(strict_types = 1);

namespace Adeira\Connector\Symfony\Console;

class Command extends \Symfony\Component\Console\Command\Command
{

	public function setName($name)
	{
		if (substr_count($name, ':') > 1) {
			throw new \InvalidArgumentException('It\'s allowed to use only one level namespace in command name. "adeira:" prefix is added automatically.');
		}
		return parent::setName("adeira:$name");
	}

}
