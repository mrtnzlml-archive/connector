<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Console;

use Adeira\Connector\GraphQL\SchemaFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class IntrospectionCommand extends \Adeira\Connector\Symfony\Console\Command
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

	public function __construct(SchemaFactory $schemaFactory)
	{
		parent::__construct();
		$this->schemaFactory = $schemaFactory;
	}

	protected function configure()
	{
		$this->setName('graphql:introspection');
		$this->setDescription('Introspect GraphQL schema.');
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
			$this->printOutputType($input, $output, $objectType);
		}
	}

	private function printOutputType(
		InputInterface $input,
		OutputInterface $output,
		\GraphQL\Type\Definition\ObjectType $objectType
	) {
		$output->writeln("<fg=blue;options=bold>type $objectType {</>");
		foreach ($objectType->getFields() as $name => $fieldDefinition) {
			$arguments = [];
			/** @var \GraphQL\Type\Definition\FieldArgument $arg */
			foreach ($fieldDefinition->args as $arg) {
				$arguments[] = $arg->name . ': ' . (string)$arg->getType() . $this->formatComment($arg->description);
			}
			$arguments = $this->formatArguments($arguments);
			$output->writeln(
				"  $name<fg=yellow>$arguments</>: <fg=green>{$fieldDefinition->getType()}</>" . $this->formatComment($fieldDefinition->description)
			);
		}

		$output->writeln('<fg=blue;options=bold>}</>');
		$output->writeln('');
	}

	private function formatArguments($arguments)
	{
		return $arguments ? "(\n    " . implode("\n    ", $arguments) . "\n  )" : '';
	}

	private function formatComment(string $comment = NULL)
	{
		$comment = $comment ? " # $comment" : '';
		return "<fg=magenta>$comment</>";
	}

}
