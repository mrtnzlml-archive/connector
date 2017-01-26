<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Common\Infrastructure\Application\Service;

use Adeira\Connector\Common\Infrastructure\Application\Service\DummySession;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DummySessionTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatSessionExecutionWorks()
	{
		$dummySession = new DummySession;
		Assert::same('without change', $dummySession->executeAtomically(function () {
			return 'without change';
		}));
	}

}

(new DummySessionTest)->run();
