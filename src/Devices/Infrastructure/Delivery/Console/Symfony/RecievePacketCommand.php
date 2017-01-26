<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\Console\Symfony;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RecievePacketCommand extends \Adeira\Connector\Symfony\Console\Command
{

	protected function configure()
	{
		$this->setName('recieve:udp');
		$this->setDescription('Listen for incoming UDP datagrams.');
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
