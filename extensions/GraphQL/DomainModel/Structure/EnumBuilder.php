<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\DomainModel\Structure;

final class EnumBuilder
{

	public static function buildEnumValues(array $enumDetails)
	{
		$output = [];
		foreach ($enumDetails as $enumName => $enumDetail) {
			$output[$enumName] = [
				'value' => $enumDetail,
			];
		}
		return $output;
	}

}
