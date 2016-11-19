<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Infrastructure\UI\Console;

use Adeira\Connector\Identity\Application\Service\CreateUserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{

	/** @var \Adeira\Connector\Identity\Application\Service\CreateUserService */
	private $createUserService;

	public function injectDependencies(CreateUserService $createUserService)
	{
		$this->createUserService = $createUserService;
	}

	protected function configure()
	{
		$this->setName('app:create:user');
		$this->addArgument('name', InputArgument::REQUIRED, 'What is the name of new user?');
		$this->addArgument('password', InputArgument::REQUIRED, 'What is the password of newly created user?');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		try {
			$this->createUserService->execute(
				$input->getArgument('name'),
				$input->getArgument('password')
			);
			$output->writeln('<info>New user has been successfully created.</info>');
		} catch (\Adeira\Connector\Identity\Application\Exception\DuplicateNameException $exc) {
			$output->writeln("<error>{$exc->getMessage()}</error>");
		}
	}

}
