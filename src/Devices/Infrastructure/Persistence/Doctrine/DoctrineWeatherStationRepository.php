<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Authentication\DomainModel\User\User;
use Adeira\Connector\Authentication\DomainModel\User\UserId;
use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IWeatherStationRepository,
	WeatherStation,
	WeatherStationId
};
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
class DoctrineWeatherStationRepository /*extends ORM\EntityRepository*/ implements IWeatherStationRepository
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

	public function ofId(WeatherStationId $weatherStationId)//: ?WeatherStation
	{
		return $this->weatherStationRepository->findOneBy([
			'id' => $weatherStationId,
		]);
	}

	public function all(UserId $userId)
	{
		$qb = $this->em->createQueryBuilder();
		$qb->from(WeatherStation::class, 'd')
			->leftJoin(User::class, 'u')
			->select([
				'd', // only data sources
			])->where('u.id = :userId')->setParameter(':userId', $userId);
		return $qb->getQuery()->getResult();
	}

	public function nextIdentity(): WeatherStationId
	{
		return WeatherStationId::create();
	}

}
