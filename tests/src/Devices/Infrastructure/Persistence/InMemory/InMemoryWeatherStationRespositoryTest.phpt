<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\Devices\Infrastructure\Persistence\InMemory;

use Adeira\Connector\Authentication\DomainModel\{
	Owner\Owner, User\User, User\UserId
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	WeatherStation, WeatherStationId
};
use Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine\InMemoryWeatherStationRepository;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class InMemoryWeatherStationRespositoryTest extends \Adeira\Connector\Tests\TestCase
{

	public function testThatOfIdWorks()
	{
		$repository = new InMemoryWeatherStationRepository;
		$wid = WeatherStationId::createFromString('00000000-0000-0000-0000-000000000001');
		Assert::null($repository->ofId($wid));
		$repository->add($station = $this->createWeatherStation($wid));
		Assert::same($station, $repository->ofId($wid));
	}

	/**
	 * TODO: nelze zatím dobře testovat, protože specifikace jsou navázané na Doctrine
	 */
	public function testSpecificationMethods()
	{
		$repository = new InMemoryWeatherStationRepository;
		$specification = new class implements \Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\ISpecification {
			public function match(\Doctrine\ORM\QueryBuilder $qb, string $dqlAlias) {}
			public function isSatisfiedBy(string $candidate): bool {}
		};

		Assert::exception(function() use ($repository, $specification) {
			$repository->countBySpecification($specification);
		}, \Nette\NotImplementedException::class);
		Assert::exception(function() use ($repository, $specification) {
			$repository->findBySpecification($specification);
		}, \Nette\NotImplementedException::class);
	}

	public function testThatNextIdentityWorks()
	{
		$repository = new InMemoryWeatherStationRepository;
		$id = $repository->nextIdentity();
		Assert::type(WeatherStationId::class, $id);
		Assert::type('string', $id->id());
	}

	private function createWeatherStation(?WeatherStationId $weatherStationId = NULL)
	{
		return new WeatherStation(
			$weatherStationId ?? WeatherStationId::create(),
			new Owner(new User(UserId::create(), 'User Name')),
			'Weather Station Name'
		);
	}

}

(new InMemoryWeatherStationRespositoryTest)->run();
