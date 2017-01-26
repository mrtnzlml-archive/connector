<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Doctrine;

use Adeira\Connector\Devices\DomainModel\WeatherStation\WeatherStationRecordId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class DoctrineWeatherStationRecordIdType extends \Adeira\Connector\Common\Infrastructure\DomainModel\DoctrineEntityId
{

	public function getTypeName(): string
	{
		return 'WeatherStationRecordId'; //(DC2Type:WeatherStationRecordId)
	}

	/**
	 * @param null|string $value
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform): WeatherStationRecordId
	{
		$uuid = parent::convertToPHPValue($value, $platform);
		return WeatherStationRecordId::create($uuid);
	}

}
