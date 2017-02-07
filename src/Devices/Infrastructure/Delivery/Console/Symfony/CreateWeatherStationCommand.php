<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Delivery\Console\Symfony;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\Application\Service\WeatherStation\Command\CreateWeatherStation;
use Adeira\Connector\ServiceBus\DomainModel\ICommandBus;
use Symfony\Component\Console\{
	Input\InputArgument,
	Input\InputInterface,
	Output\OutputInterface,
	Style\SymfonyStyle
};

final class CreateWeatherStationCommand extends \Adeira\Connector\Symfony\Console\Command
{

	private $commandBus;

	public function __construct(ICommandBus $commandBus)
	{
		parent::__construct('weatherStation:create');
		$this->commandBus = $commandBus;
	}

	protected function configure()
	{
		$this->setDescription('Add new data source to the database.');
		$this->addArgument('userId', InputArgument::REQUIRED, 'ID of the data source owner?');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$userId = $input->getArgument('userId');

		$this->commandBus->dispatch(new CreateWeatherStation(
			'Device Name',
			UserId::createFromString($userId)
		));

		$styleGenerator = new SymfonyStyle($input, $output);
		$styleGenerator->success('New weather station has been created.');
	}

}
