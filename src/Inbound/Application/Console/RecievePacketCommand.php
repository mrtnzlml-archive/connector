<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecievePacketCommand extends \Symfony\Component\Console\Command\Command
{

	protected function configure()
	{
		$this->setName('app:inbound:udp');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		socket_bind($socket, '127.0.0.1', 50505);

		while (TRUE) {
			socket_recv($socket, $buf, 500, 0);
			echo $buf . PHP_EOL;
		}
	}

}
