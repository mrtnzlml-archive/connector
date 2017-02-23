<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\Persistence\InMemory;

use Adeira\Connector\Authentication\DomainModel\{
	Owner\Owner, User\User, User\UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStation, WeatherStationId
};
use Adeira\Connector\Devices\Infrastructure\Persistence\InMemory\InMemoryAllWeatherStations;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class InMemoryWeatherStationRespositoryTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatWithIdWorks()
	{
		$repository = new InMemoryAllWeatherStations;
		$wid = WeatherStationId::createFromString('00000000-0000-0000-0000-000000000001');
		$owner = new Owner(new User(UserId::create(), 'username'));
		Assert::null($repository->withId($owner, $wid)->hydrate()); // WS doesn't exist yet

		$repository->add($station = $this->createWeatherStation($wid, $owner));
		Assert::same($station, $repository->withId($owner, $wid)->hydrateOne()); // WS with this UUID exists
		Assert::null($repository->withId(clone $owner, $wid)->hydrate()); // WS with this cloned UUID doens't exist
	}

	public function testThatBelongingToWorks()
	{
		$repository = new InMemoryAllWeatherStations;
		$owner = new Owner(new User(UserId::create(), 'username'));
		$repository->add($station = $this->createWeatherStation(NULL, $owner));

		Assert::type(WeatherStation::class, $repository->belongingTo($owner)->hydrateOne());
		Assert::null($repository->belongingTo(new Owner(new User(UserId::create(), 'u')))->hydrateOne());
	}

	public function testThatNextIdentityWorks()
	{
		$repository = new InMemoryAllWeatherStations;
		$id = $repository->nextIdentity();
		Assert::type(WeatherStationId::class, $id);
		Assert::type('string', $id->toString());
	}

	private function createWeatherStation(?WeatherStationId $weatherStationId = NULL, ?Owner $owner = NULL)
	{
		return new WeatherStation(
			$weatherStationId ?? WeatherStationId::create(),
			$owner ?? new Owner(new User(UserId::create(), 'User Name')),
			'Weather Station Name',
			new \DateTimeImmutable
		);
	}

}

(new InMemoryWeatherStationRespositoryTest)->run();
