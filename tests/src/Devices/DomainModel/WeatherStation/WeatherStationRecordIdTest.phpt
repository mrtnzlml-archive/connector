<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecordId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class WeatherStationRecordIdTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatConstructorIsPrivate()
	{
		Assert::exception(function () {
			new WeatherStationRecordId;
		}, \Error::class, 'Call to private ' . WeatherStationRecordId::class . '::__construct() from context%a%');
	}

	public function testThatSameValuesAreEqual()
	{
		$id1 = WeatherStationRecordId::create($uuid = Uuid::uuid4());
		$id2 = WeatherStationRecordId::create($uuid);
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

	public function testThatDifferentValuesAreNotEqual()
	{
		$id1 = WeatherStationRecordId::create(Uuid::uuid4());
		$id2 = WeatherStationRecordId::create(Uuid::uuid4());
		Assert::notSame($id1, $id2);
		Assert::false($id1->equals($id2));
		Assert::false($id2->equals($id1));
	}

}

(new WeatherStationRecordIdTest)->run();
