<?php declare(strict_types = 1);

namespace Adeira\Connector\Devices\Infrastructure\DomainModel\WeatherStation\Series\WS3600;

use Adeira\Connector\Devices\DomainModel\WeatherStation\{
	IFileLoader
};

/**
 * @see http://www.niftythings.org/HeavyWeather%20History%20Format.txt
 *
 * HeavyWeatherPro V1.1
 * La Crosse WS-3610 weather station
 *
 * Each row of data is stored in 56 byte chunks starting from the beginning of the file (no header).
 *
 * ROW
 * OFFSET  Type        Name               Unit
 * ------  ---------   ----------------   -----
 * 00      Double [8]  Timestamp          days from 12/30/1899 00:00:00 (GMT)
 * 08      Float  [4]  Abs Pressure       hectopascals (millibars)
 * 12      Float  [4]  Relative Pressure  hectopascals (millibars)
 * 16      Float  [4]  Wind Speed         meters/second
 * 20      ULong  [4]  Wind Direction     see below
 * 24      Float  [4]  Wind Gust          meters/second
 * 28      Float  [4]  Total Rainfall     millimeters
 * 32      Float  [4]  New Rainfall       millimeters
 * 36      Float  [4]  Indoor Temp        celsius
 * 40      Float  [4]  Outdoor Temp       celsius
 * 44      Float  [4]  Indoor Humidity    %
 * 48      Float  [4]  Outdoor Humidity   %
 * 52      ULong  [4]  unknown            - (Value is always 0)
 *
 * Since the timestamp is a double, the fractional part represents fractions of a day. This is probably the same type
 * as the Delphi TdateTime type.
 *
 * Wind direction is encoded as an integer between 0 and 15. To get the wind direction in degrees, multiply the value
 * by 22.5. To get compass directions (moving clockwise) 0 is North, 1 is North-Northeast, 2 is Northeast, etc...
 *
 *  0   | 1   | 2   | 3   | 4   | 5   | 6   | 7   | 8   | 9   | 10   | 11   | 12   | 13   | 14   | 15
 *  N   | NNE | NE  | ENE | E   | ESE | SE  | SSE | S   | SSW | SW   | WSW  | W    | WNW  | NW   | NNW
 */
final class HistoryFileLoader implements IFileLoader
{

	private const PACK_LENGTH = 56;

	/**
	 * @var array Binary data format definition for 'unpack' function.
	 */
	private $binaryDataFormat = [
		'timestamp' => 'd',
		'absPressure' => 'f', // valid range: < 300 mbar ; 1100 mbar >
		'relPressure' => 'f', // valid range: < 300 mbar ; 1100 mbar >
		'windSpeed' => 'f', // valid range: < 0 ; 50 ms >
		'windDirection' => 'V', // valid range: < 0 ; 15 >
		'windGust' => 'f', // valid range: < 0 ; 50 ms >
		'totalRainfall' => 'f', // valid range: < 0 ; 10 000 mm >
		'newRainfall' => 'f',
		'indoorTemp' => 'f', // valid range: < -10 °C ; 60 °C >
		'outdoorTemp' => 'f', // valid range: < -40 °C ; 60 °C >
		'indoorHumidity' => 'f', // valid range: < 1 % ; 99 % >
		'outdoorHumidity' => 'f', // valid range: < 1 % ; 99 % >
		'__unknown' => 'V',
	];

	public function yieldWeatherStationRecord(string $fileName): \Generator
	{
		$resource = fopen($fileName, 'rb');
		while (TRUE) { // It's not possible to use 'feof' here (EOF doesn't exist).
			$format = $sep = '';
			foreach($this->binaryDataFormat as $name => $type) {
				$format .= $sep . $type . $name;
				$sep = '/';
			}

			$bytes = fread($resource, self::PACK_LENGTH);
			if($bytes === '') {
				break;
			}

			$data = unpack($format, $bytes);

			//TODO: DTO (?)
			$baseDate = new \DateTimeImmutable('1899-12-30T00:00:00+00:00');
			$seconds = $data['timestamp'] * 24 * 60 * 60;
			$data['timestamp'] = $baseDate->add(new \DateInterval("PT{$seconds}S"));
			$data['windSpeed'] = $this->validateRange($data['windSpeed'], 0, 50);
			$data['windDirection'] = $this->validateRange($data['windDirection'], 0, 15);
			$data['windGust'] = $this->validateRange($data['windGust'], 0, 50);
			$data['outdoorTemp'] = $this->validateRange($data['outdoorTemp'], -40, 60);
			$data['outdoorHumidity'] = $this->validateRange($data['outdoorHumidity'], 0, 99);

			yield $data;
		}
	}

	private function validateRange($actualValue, $min, $max, $failedValue = NULL)
	{
		if($actualValue >= $min && $actualValue <= $max) {
			return $actualValue;
		}
		return $failedValue;
	}

}
