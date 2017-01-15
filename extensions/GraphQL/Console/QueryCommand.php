<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Console;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\GraphQL\SchemaFactory;
use Symfony\Component\Console\Input\{
	InputArgument, InputInterface
};
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class QueryCommand extends \Adeira\Connector\Symfony\Console\Command
{

	/** @var \Adeira\Connector\GraphQL\SchemaFactory */
	private $schemaFactory;

	public function __construct(SchemaFactory $schemaFactory)
	{
		parent::__construct();
		$this->schemaFactory = $schemaFactory;
	}

	protected function configure()
	{
		$this->setName('graphql:query');
		$this->setDescription('Query GraphQL API via command line.');
		$this->addArgument('requestString', InputArgument::REQUIRED);
		$this->addArgument('userId', InputArgument::REQUIRED);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$graphResponse = \GraphQL\GraphQL::execute(
			$this->schemaFactory->build(),
			$input->getArgument('requestString'),
			NULL,
			UserId::createFromString($input->getArgument('userId'))
		);
		$style = new SymfonyStyle($input, $output);
		$style->block(json_encode($graphResponse, JSON_PRETTY_PRINT));
	}

}
