<?php declare(strict_types = 1);

namespace Adeira\Connector\Tests\GraphQL\Type;

use Adeira\Connector\GraphQL\Type\InputObject;
use Tester\Assert;

require getenv('BOOTSTRAP');

/**
 * @testCase
 */
final class InputObjectTest extends \Adeira\Connector\Tests\TestCase
{

	public function testMinimalStructure() {
		$structure = (new class extends InputObject {
			public function publicName(): string {
				return 'Public Name';
			}
			public function fields(): array {
				return [];
			}
		})->_buildStructure();
		Assert::same([
			'name' => 'Public Name',
			'description' => NULL,
		], $structure);
	}

	public function testFullStructure() {
		$structure = (new class extends InputObject {
			public function publicName(): string {
				return 'Public Name';
			}
			public function publicDescription(): ?string {
				return 'Description';
			}
			public function fields(): array {
				return [];
			}
		})->_buildStructure();
		Assert::same([
			'name' => 'Public Name',
			'description' => 'Description',
		], $structure);
	}

	public function testStructureWithoutPublicName()
	{
		Assert::exception(function() {
			(new class extends InputObject {})->_buildStructure();
		}, \Adeira\Connector\GraphQL\Exception\OverrideException::class, "You MUST override method 'publicName' in '%a%' because it's required.");
	}

	public function testStructureWithoutFields()
	{
		Assert::exception(function() {
			(new class extends InputObject {
				public function publicName(): string {
					return 'Public Name';
				}
			})->_buildStructure();
		}, \Adeira\Connector\GraphQL\Exception\OverrideException::class, "You MUST override method 'fields' in '%a%' because it's required.");
	}

}

(new InputObjectTest)->run();
