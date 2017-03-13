<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\Persistence\Doctrine;

use Adeira\Connector\Authentication\DomainModel\Owner\Owner;
use Adeira\Connector\Common\DomainModel\Stub;
use Adeira\Connector\Devices\DomainModel\Camera\{
	Camera, CameraId, IAllCameras
};
use Doctrine\ORM;

/**
 * Do not call flush() here! Flushing and dealing with transactions is delegated to the Application Service.
 * All behavior should still follow the Repositories’ collection characteristics.
 */
final class DoctrineAllCameras implements IAllCameras
{

	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	public function __construct(ORM\EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function add(Camera $camera): void
	{
		$this->em->persist($camera);
	}

	public function remove(Camera $camera): void
	{
		$this->em->remove($camera);
	}

	public function withId(Owner $owner, CameraId $cameraId): ?Camera
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlias = 'cam')->from(Camera::class, $dqlAlias);
		$qb->where('cam.ownerId = :ownerId')->setParameter(':ownerId', $owner->id()->toString());
		$qb->andWhere('cam.id = :id')->setParameter(':id', $cameraId->toString());

		return $qb->getQuery()->getSingleResult();
	}

	public function belongingTo(Owner $owner): Stub
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select($dqlAlias = 'cam')->from(Camera::class, $dqlAlias);
		$qb->andWhere('cam.ownerId = :ownerId')->setParameter(':ownerId', $owner->id()->toString());

		return Stub::wrap($qb);
	}

	public function nextIdentity(): CameraId
	{
		return CameraId::create();
	}

}
