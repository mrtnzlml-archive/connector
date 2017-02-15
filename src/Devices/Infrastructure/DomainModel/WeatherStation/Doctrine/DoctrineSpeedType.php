<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Doctrine;

use Adeira\Connector\PhysicalUnits\IPhysicalQuantity;
use Adeira\Connector\PhysicalUnits\Speed\Speed;
use Adeira\Connector\PhysicalUnits\Speed\Units\Kmh;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineSpeedType extends \Doctrine\DBAL\Types\Type
{

	public function getName(): string
	{
		return 'Speed'; //(DC2Type:Speed)
	}

	/**
	 * Return the SQL used to create your column type. To create a portable column type, use the $platform.
	 */
	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
	{
		return $platform->getFloatDeclarationSQL($fieldDeclaration);
	}

	/**
	 * This is executed when the value is read from the database. Make your conversions here, optionally using the $platform.
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return new Speed(new Kmh($value));
	}

	/**
	 * This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value instanceof IPhysicalQuantity) {
			return $value->convertTo(Kmh::class)->value();
		}
		return NULL;
	}

}
