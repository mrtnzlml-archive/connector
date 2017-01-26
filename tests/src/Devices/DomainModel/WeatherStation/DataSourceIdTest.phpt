<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\DomainModel\WeatherStation;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationId;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class DataSourceIdTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatConstructorIsPrivate()
	{
		Assert::exception(function () {
			new WeatherStationId;
		}, \Error::class, 'Call to private ' . WeatherStationId::class . '::__construct() from context%a%');
	}

	public function testThatSameValuesAreEqual()
	{
		$id1 = WeatherStationId::create($uuid = Uuid::uuid4());
		$id2 = WeatherStationId::create($uuid);
		Assert::notSame($id1, $id2);
		Assert::true($id1->equals($id2));
		Assert::true($id2->equals($id1));
	}

	public function testThatDifferentValuesAreNotEqual()
	{
		$id1 = WeatherStationId::create(Uuid::uuid4());
		$id2 = WeatherStationId::create(Uuid::uuid4());
		Assert::notSame($id1, $id2);
		Assert::false($id1->equals($id2));
		Assert::false($id2->equals($id1));
	}

}

(new DataSourceIdTest)->run();
