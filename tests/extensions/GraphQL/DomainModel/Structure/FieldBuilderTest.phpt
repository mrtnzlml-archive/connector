<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\DomainModel\Structure;

use Adeira\Connector\GraphQL\DomainModel\Structure\FieldBuilder;
use Adeira\Connector\GraphQL\DomainModel\Structure\FieldBuilderResponse;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class FieldBuilderTest extends \Adeira\Connector\Tests\TestCase
{

	// SIMPLE FIELDS:

	public function testSimpleResolve()
	{
		$response = FieldBuilder::resolveField('simple');
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::false($response->isScalar());
		Assert::false($response->isListOf());
		Assert::false($response->isNonNull());
	}

	public function testNonNullSimpleResolve()
	{
		$response = FieldBuilder::resolveField('simple!');
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::false($response->isScalar());
		Assert::false($response->isListOf());
		Assert::true($response->isNonNull());
	}

	public function testListOfSimpleResolve()
	{
		$response = FieldBuilder::resolveField(['simple']);
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::false($response->isScalar());
		Assert::true($response->isListOf());
		Assert::false($response->isNonNull());
	}

	public function testListOfNonNullSimpleResolve()
	{
		$response = FieldBuilder::resolveField(['simple!']);
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::false($response->isScalar());
		Assert::true($response->isListOf());
		Assert::true($response->isNonNull());
	}

	// SCALAR FIELDS:

	public function testScalarResolve()
	{
		$response = FieldBuilder::resolveField('Int');
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::true($response->isScalar());
		Assert::same('int', $response->value());
		Assert::false($response->isListOf());
		Assert::false($response->isNonNull());

		$response = FieldBuilder::resolveField('int'); //lowercase
		Assert::false($response->isScalar());
	}

	public function testNonNullScalarResolve()
	{
		$response = FieldBuilder::resolveField('Int!');
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::true($response->isScalar());
		Assert::same('int', $response->value());
		Assert::false($response->isListOf());
		Assert::true($response->isNonNull());
	}

	public function testListOfScalarResolve()
	{
		$response = FieldBuilder::resolveField(['Int']);
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::true($response->isScalar());
		Assert::same('int', $response->value());
		Assert::true($response->isListOf());
		Assert::false($response->isNonNull());
	}

	public function testListOfNonNullScalarResolve()
	{
		$response = FieldBuilder::resolveField(['Int!']);
		Assert::type(FieldBuilderResponse::class, $response);
		Assert::true($response->isScalar());
		Assert::same('int', $response->value());
		Assert::true($response->isListOf());
		Assert::true($response->isNonNull());
	}

}

(new FieldBuilderTest)->run();
