<?php declare(strict_types = 1);

namespace Adeira\Connector\PhysicalUnits\Infrastructure\DomainModel\Doctrine;

use Adeira\Connector\PhysicalUnits\IPhysicalQuantity;
use Adeira\Connector\PhysicalUnits\Temperature\Temperature;
use Adeira\Connector\PhysicalUnits\Temperature\Units\Celsius;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineTemperatureType extends \Doctrine\DBAL\Types\Type
{

	public function getName(): string
	{
		return 'Temperature'; //(DC2Type:Temperature)
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
		return new Temperature(new Celsius($value));
	}

	/**
	 * This is executed when the value is written to the database. Make your conversions here, optionally using the $platform.
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value instanceof IPhysicalQuantity) {
			return $value->convertTo(Celsius::class)->value();
		}
		return NULL;
	}

}
