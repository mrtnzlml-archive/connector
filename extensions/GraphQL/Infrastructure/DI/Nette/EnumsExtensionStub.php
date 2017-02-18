<?php declare(strict_types = 1);

namespace Adeira\Connector\GraphQL\Infrastructure\DI\Nette;

final class EnumsExtensionStub
{

	public function registerEnums(Extension $extension, array $enums)
	{
		$builder = $extension->getContainerBuilder();
		foreach ($enums as $enumName => $enumDetails) {
			$builder
				->addDefinition($extension->prefix("enum.$enumName"))
				->setClass(\GraphQL\Type\Definition\EnumType::class)
				->setArguments([
					'config' => [
						'name' => $enumName,
						'values' => $this->buildEnumValues($enumDetails),
					],
				]);
		}
	}

	private function buildEnumValues(array $enumDetails): array
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
