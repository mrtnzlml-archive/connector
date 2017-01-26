<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Common\Infrastructure\DomainModel\Doctrine\Specification\{
	Executor, ISpecification
};
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRepository, WeatherStation, WeatherStationId
};
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
final class DoctrineWeatherStationRepository /*extends ORM\EntityRepository*/ implements IWeatherStationRepository
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	/**
	 * @var \Doctrine\Common\Persistence\ObjectRepository
	 */
	private $weatherStationRepository;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
		$this->weatherStationRepository = $em->getRepository(WeatherStation::class);
	}

	public function add(WeatherStation $aWeatherStation)
	{
		$this->em->persist($aWeatherStation);
	}

	public function ofId(WeatherStationId $weatherStationId): ?WeatherStation
	{
		return $this->weatherStationRepository->findOneBy([
			'id' => $weatherStationId,
		]);
	}

	/**
	 * TODO: findOneBySpecification
	 *
	 * `Spec` je composable (and/or/not) specifikace ktera urcuje mnozinu zaznamu co se budou selektovat
	 * `Selection` je jeden (non-composable) objekt ktery urcuje jak se budou selektovat (entity, jen idcka, pole id =>
	 * nazev) apod.
	 *
	 * Spec dostane nakonfigurovany query builder (zakladni qb pro aggregate se vsemi joiny apod, napr. `deleted =
	 * false` jde sem) a vrati expr objekt
	 * Selection dostane finalni query builder a vrati vysledek
	 *
	 * @throws \InvalidArgumentException
	 */
	public function findBySpecification(ISpecification $specification): array
	{
		$qb = Executor::prepareQueryBuilder($this->em, $specification, WeatherStation::class, 'ws');
		return $qb->getQuery()->getResult();
	}

	public function nextIdentity(): WeatherStationId
	{
		return WeatherStationId::create();
	}

}
