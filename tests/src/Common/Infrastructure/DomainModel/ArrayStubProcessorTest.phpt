<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Common\Infrastructure\Application\Service;

use Adeira\Connector\Common\Infrastructure\DomainModel\ArrayStubProcessor;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class ArrayStubProcessorTest extends \Adeira\Connector\Tests\TestCase
{

	/** @var array */
	private $stub;

	public function setUp()
	{
		$this->stub = [
			'key' => ['ak1', 'ak2'],
			['bk1', 'bk2'],
			new class {},
		];
	}

	public function testFirst()
	{
		$processor = new ArrayStubProcessor($this->stub);
		$processor->first(2);

		Assert::same([
			'key' => ['ak1', 'ak2'],
			['bk1', 'bk2'],
		], $processor->hydrate());
		Assert::same(['ak1', 'ak2'], $processor->hydrateOne());
		Assert::same(2, $processor->hydrateCount());
	}

	public function testNotSupportedMethods()
	{
		$processor = new ArrayStubProcessor($this->stub);

		Assert::exception(function () use ($processor) {
			$processor->orientation('key');
		}, \Nette\NotSupportedException::class);

		Assert::exception(function () use ($processor) {
			$processor->after('identifier', 'key', 'value');
		}, \Nette\NotSupportedException::class);

		Assert::exception(function () use ($processor) {
			$processor->applyExpression(new \Doctrine\Common\Collections\Expr\Value('value'));
		}, \Nette\NotSupportedException::class);
	}

}

(new ArrayStubProcessorTest)->run();
