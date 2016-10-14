<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Domain\Device;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="devices")
 */
class Device
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid_binary")
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
	private $uuid;

	/**
	 * @ORM\Column(type="jsonb")
	 */
	private $jsonb;

}
