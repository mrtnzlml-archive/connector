<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Console;

use Adeira\Connector\GraphQL\SchemaFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IntrospectionCommand extends \Symfony\Component\Console\Command\Command
{

	/** @var \Adeira\Connector\GraphQL\SchemaFactory */
	private $schemaFactory;

	private $internalTypes = [
		'String',
		'Int',
		'__Schema',
		'__Type',
		'__TypeKind',
		'Boolean',
		'__Field',
		'__InputValue',
		'__EnumValue',
		'__Directive',
		'__DirectiveLocation',
		'ID',
		'Float',
	];

	public function injectDependencies(SchemaFactory $schemaFactory)
	{
		$this->schemaFactory = $schemaFactory;
	}

	protected function configure()
	{
		$this->setName('app:graphql:introspection')->setDescription('Introspect GraphQL schema.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$schema = $this->schemaFactory->build();

		/** @var \GraphQL\Type\Definition\Type $objectType */
		foreach ($schema->getTypeMap() as $typeName => $objectType) {
			// skip internal types
			if (in_array($typeName, $this->internalTypes)) {
				continue;
			}

			//TODO: printInputType
			if (!$objectType instanceof \GraphQL\Type\Definition\InputType) {
				$this->printOutputType($input, $output, $objectType);
			}
		}
	}

	private function printOutputType(
		InputInterface $input,
		OutputInterface $output,
		\GraphQL\Type\Definition\Type $objectType
	) {
		$output->writeln("<fg=blue;options=bold>type $objectType {</>");
		foreach ($objectType->getFields() as $name => $fieldDefinition) {
			$arguments = [];
			/** @var \GraphQL\Type\Definition\FieldArgument $arg */
			foreach ($fieldDefinition->args as $arg) {
				$arguments[] = $arg->name . ': ' . (string)$arg->getType();
			}
			$arguments = $arguments ? '(' . implode(', ', $arguments) . ')' : '';
			$output->writeln("  $name<fg=yellow>$arguments</>: <fg=green>{$fieldDefinition->getType()}</>");
		}
		$output->writeln('<fg=blue;options=bold>}</>');
		$output->writeln('');
	}

}
