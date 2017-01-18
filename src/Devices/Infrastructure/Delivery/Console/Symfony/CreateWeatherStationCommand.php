<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\Console\Symfony;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\{
	AddWeatherStationRecordRequest,
	AddWeatherStationRecordService,
	AddWeatherStationRequest,
	AddWeatherStationService
};
use Nette\Utils\Json;
use Symfony\Component\Console\{
	Input\InputArgument,
	Input\InputInterface,
	Output\OutputInterface,
	Style\SymfonyStyle
};

class CreateWeatherStationCommand extends \Adeira\Connector\Symfony\Console\Command
{

	/**
	 * @var AddWeatherStationService
	 */
	private $weatherStationService;

	/**
	 * @var AddWeatherStationRecordService
	 */
	private $addWeatherStationRecordService;

	public function __construct(
		AddWeatherStationService $addWeatherStationService,
		AddWeatherStationRecordService $addWeatherStationRecordService
	) {
		parent::__construct('weatherStation:create');
		$this->weatherStationService = $addWeatherStationService;
		$this->addWeatherStationRecordService = $addWeatherStationRecordService;
	}

	protected function configure()
	{
		$this->setDescription('Add new data source to the database.');
		$this->addArgument('userId', InputArgument::REQUIRED, 'ID of the data source owner?');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$userId = $input->getArgument('userId');
		$response = $this->weatherStationService->execute(
			new AddWeatherStationRequest(
				'Device Name',
				UserId::createFromString($userId)
			)
		);

		// FIXME: remove
		$weatherStationId = $response->id();
		$this->addWeatherStationRecordService->execute(new AddWeatherStationRecordRequest($weatherStationId, 101325));
		$this->addWeatherStationRecordService->execute(new AddWeatherStationRecordRequest($weatherStationId, 101300));

		$styleGenerator = new SymfonyStyle($input, $output);
		$styleGenerator->success("New device with UUID {$response->id()} has been created.");
	}

}
