<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\Camera;

use Adeira\Connector\Devices\DomainModel\Camera\CameraId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class CameraIdTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatConstructorIsPrivate()
	{
		Assert::exception(function () {
			new CameraId;
		}, \Error::class, 'Call to private ' . CameraId::class . '::__construct() from context%a%');
	}

	public function testThatSameValuesAreEqual()
	{
		$id1 = CameraId::create($uuid = Uuid::uuid4());
		$id2 = CameraId::create($uuid);
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

	public function testThatDifferentValuesAreNotEqual()
	{
		$id1 = CameraId::create(Uuid::uuid4());
		$id2 = CameraId::create(Uuid::uuid4());
		Assert::notSame($id1, $id2);
		Assert::false($id1->equals($id2));
		Assert::false($id2->equals($id1));
	}

}

(new CameraIdTest)->run();
