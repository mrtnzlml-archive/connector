<?php declare(strict_types = 1);

namespace Adeira\Connector\Symfony\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class UuidCommand extends Command
{

	public function __construct()
	{
		$this->setDescription('Generate next UUID.');
		parent::__construct('uuid');
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$style = new SymfonyStyle($input, $output);
		$style->block(\Ramsey\Uuid\Uuid::uuid4(), 'UUID');
	}

}
