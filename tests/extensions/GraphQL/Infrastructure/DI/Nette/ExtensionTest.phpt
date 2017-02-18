<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Infrastructure\DI\Nette;

use Tester\Assert;

require getenv('BOOTSTRAP');
require __DIR__ . '/ContainerBuilder.php';

/**
 * @testCase
 */
final class ExtensionTest extends \Adeira\Connector\Tests\TestCase
{

	public function testEmpty()
	{
		Assert::noError(function () {
			ContainerBuilder::createContainer(__DIR__ . '/config/empty.neon');
		});
	}

	// SIMPLE FIELDS:

	public function testSimpleResolve()
	{
		$response = $this->extension()->resolveGraphQLType('simple');
		Assert::equal(
			(new \Nette\DI\ServiceDefinition)->setClass(\stdClass::class),
			$response
		);
	}

	public function testNonNullSimpleResolve()
	{
		$response = $this->extension()->resolveGraphQLType('simple!');
		Assert::equal(
			new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::nonNull(?)', [
				(new \Nette\DI\ServiceDefinition)->setClass(\stdClass::class),
			]),
			$response
		);
	}

	public function testListOfSimpleResolve()
	{
		$response = $this->extension()->resolveGraphQLType(['simple']);
		Assert::equal(
			new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::listOf(?)', [
				(new \Nette\DI\ServiceDefinition)->setClass(\stdClass::class),
			]),
			$response
		);
	}

	public function testListOfNonNullSimpleResolve()
	{
		$response = $this->extension()->resolveGraphQLType(['simple!']);
		Assert::equal(
			new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::listOf(?)', [
				new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::nonNull(?)', [
					(new \Nette\DI\ServiceDefinition)->setClass(\stdClass::class),
				]),
			]),
			$response
		);
	}

	// SCALAR FIELDS:

	public function testScalarResolve()
	{
		$response = $this->extension()->resolveGraphQLType('Int');
		Assert::equal(
			new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::?()', ['int']),
			$response
		);

		Assert::exception(function () {
			$this->extension()->resolveGraphQLType('int'); //lowercase (not native GraphQL type)
		}, \Nette\DI\MissingServiceException::class, "Service 'graphql.enum.int' not found.");
	}

	public function testNonNullScalarResolve()
	{
		$response = $this->extension()->resolveGraphQLType('Int!');
		Assert::equal(
			new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::nonNull(?)', [
				new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::?()', ['int']),
			]),
			$response
		);
	}

	public function testListOfScalarResolve()
	{
		$response = $this->extension()->resolveGraphQLType(['Int']);
		Assert::equal(
			new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::listOf(?)', [
				new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::?()', ['int']),
			]),
			$response
		);
	}

	public function testListOfNonNullScalarResolve()
	{
		$response = $this->extension()->resolveGraphQLType(['Int!']);
		Assert::equal(
			new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::listOf(?)', [
				new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::nonNull(?)', [
					new \Nette\DI\Statement('\GraphQL\Type\Definition\Type::?()', ['int']),
				]),
			]),
			$response
		);
	}

	private function extension()
	{
		$containerBuilder = new \Nette\DI\ContainerBuilder;
		$containerBuilder->addDefinition('graphql.enum.simple')->setClass(\stdClass::class)->setNotifier('pi');

		$extension = new \Adeira\Connector\GraphQL\Infrastructure\DI\Nette\Extension;
		$extension->setCompiler(new \Nette\DI\Compiler($containerBuilder), 'graphql');
		return $extension;
	}

}

(new ExtensionTest)->run();
