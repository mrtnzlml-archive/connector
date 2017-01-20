<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Console;

use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\GraphQL\SchemaFactory;
use Symfony\Component\Console\Input\{
	InputArgument, InputInterface, InputOption
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
		$this->addArgument('userId', InputArgument::REQUIRED);
		$this->addOption('graphQuery', 'g', InputOption::VALUE_REQUIRED, 'GraphQL query', <<<GraphQL
{
  allQueries: __type(name: "Query") {
    queries: fields {
      name
    }
  }
}
GraphQL
);
		$this->addOption('graphQueryFile', 'f', InputOption::VALUE_REQUIRED, 'GraphQL query from file');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$requestString = $input->getOption('graphQueryFile')
			? file_get_contents($input->getOption('graphQueryFile'))
			: $input->getOption('graphQuery');
		$graphResponse = \GraphQL\GraphQL::execute(
			$this->schemaFactory->build(),
			$requestString,
			NULL,
			UserId::createFromString($input->getArgument('userId'))
		);
		$style = new SymfonyStyle($input, $output);
		$style->block(json_encode($graphResponse, JSON_PRETTY_PRINT));
	}

}
