<?php declare(strict_types = 1);

use Doctrine\DBAL\Connection;

/**
 * It creates records with UUID from 00000000-0000-0000-0000-000000000001 to 00000000-0000-0000-0000-000000035000.
 */

define('RECORDS', 35000);

/** @var Nette\DI\Container $dic */
assert($dic instanceof Nette\DI\Container);
/** @var Connection $connection */
$connection = $dic->getByType(Connection::class);

$date = new \DateTimeImmutable;
$connection->beginTransaction();
$connection->setAutoCommit(FALSE);
for ($i = 1; $i <= RECORDS; $i++) { // ~ one year
	$date = $date->modify('-15 minutes');
	createNewRecord($i, $connection, $date);
}
$connection->commit();

function createNewRecord(int $index, Connection $connection, \DateTimeImmutable $creationDate)
{
	$index = \Nette\Utils\Strings::padLeft((string)$index, 12, '0');
	$creationDate = $creationDate->format('Y-m-d H:i:sP');
	$sin = sin(random_int($index - RECORDS / 10, $index + RECORDS / 10) / (RECORDS / pi()));
	$cos = cos(random_int($index - RECORDS / 10, $index + RECORDS / 10) / (RECORDS / pi()));

	$temperature_indoor = (5 * $sin) + 22;
	$temperature_outdoor = (10 * $sin) + 10;
	$pressure_absolute = -(10 * $sin) + 100000;
	$pressure_relative = (10 * $sin) + 100000;
	$humidity_indoor = (5 * $cos) + 40;
	$humidity_outdoor = (10 * $cos) + 40;
	$wind_speed = (5 * $sin) + 10;
	$wind_azimuth = (5 * $sin) + 180;
	$wind_gust = (50 * $sin) + 22;

	$connection->executeUpdate("
INSERT INTO weather_stations_records (id, weather_station_id, pressure_absolute, pressure_relative, temperature_indoor, temperature_outdoor, humidity_indoor, humidity_outdoor, wind_speed, wind_azimuth, wind_gust, creation_date)
VALUES ('00000000-0000-0000-0000-$index', '00000000-0001-0000-0000-000000000001', $pressure_absolute, $pressure_relative, $temperature_indoor, $temperature_outdoor, $humidity_indoor, $humidity_outdoor, $wind_speed, $wind_azimuth, $wind_gust, '$creationDate');
");
}
