<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Application\Console;

use Adeira\Connector\Inbound\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddDataSourceCommand extends \Symfony\Component\Console\Command\Command
{

	/** @var \Adeira\Connector\Inbound\Application\Service\AddDataSourceService */
	private $addDataSourceService;

	public function injectDependencies(Application\Service\AddDataSourceService $addDataSourceService)
	{
		$this->addDataSourceService = $addDataSourceService;
	}

	protected function configure()
	{
		$this->setName('app:add:dataSource')->setDescription('Add new data source to the database.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$styleGenerator = new SymfonyStyle($input, $output);
		$response = $this->addDataSourceService->execute(
			new Application\Service\AddDataSourceRequest('Device Name')
		);
		$styleGenerator->success("New device with UUID {$response->id()} has been created.");
	}

}
