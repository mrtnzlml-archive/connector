<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Common\Infrastructure\Application\Service;

use Adeira\Connector\Common\Infrastructure\Application\Service\DoctrineSession;
use Doctrine\ORM\EntityManagerInterface;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DoctrineSessionTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatSessionExecutionWorks()
	{
		$emMock = \Mockery::mock(EntityManagerInterface::class);
		$emMock->shouldReceive('transactional')->once()->andReturnUsing(function (callable $operation) {
			return mb_strtoupper($operation());
		});

		$doctrineSession = new DoctrineSession($emMock);
		Assert::same('I SHOULD BE UPPERCASED.', $doctrineSession->executeAtomically(function () {
			return 'I should be uppercased.';
		}));
	}

	public function tearDown()
	{
		\Mockery::close();
	}

}

(new DoctrineSessionTest)->run();
