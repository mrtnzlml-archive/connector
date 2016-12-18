<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\UI\Console;

use Adeira\Connector\Identity\DomainModel\User\UserId;
use Adeira\Connector\Inbound\Application;
use Nette\Utils\Json;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddDataSourceCommand extends \Symfony\Component\Console\Command\Command
{

	/**
	 * @var \Adeira\Connector\Inbound\Application\Service\AddDataSourceService
	 */
	private $addDataSourceService;

	/**
	 * @var \Adeira\Connector\Inbound\Application\Service\AddDataSourceRecordService
	 */
	private $addDataSourceRecordService;

	public function injectDependencies(
		Application\Service\AddDataSourceService $addDataSourceService,
		Application\Service\AddDataSourceRecordService $addDataSourceRecordService
	) {
		$this->addDataSourceService = $addDataSourceService;
		$this->addDataSourceRecordService = $addDataSourceRecordService;
	}

	protected function configure()
	{
		$this->setName('app:add:dataSource');
		$this->setDescription('Add new data source to the database.');
		$this->addArgument('userId', InputArgument::REQUIRED, 'ID of the data source owner?');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$userId = $input->getArgument('userId');
		$response = $this->addDataSourceService->execute(
			new Application\Service\AddDataSourceRequest(
				'Device Name',
				UserId::createFromString($userId)
			)
		);

		$dataSourceId = $response->id();
		$data = Json::encode(['v' => ['a' => ['l']]]);
		$this->addDataSourceRecordService->execute(new Application\Service\AddDataSourceRecordRequest($dataSourceId, $data));
		$this->addDataSourceRecordService->execute(new Application\Service\AddDataSourceRecordRequest($dataSourceId, $data));

		$styleGenerator = new SymfonyStyle($input, $output);
		$styleGenerator->success("New device with UUID {$response->id()} has been created.");
	}

}
