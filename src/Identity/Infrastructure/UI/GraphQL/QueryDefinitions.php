<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Infrastructure\UI\GraphQL;

use GraphQL\Type\Definition;

class QueryDefinitions implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var \Adeira\Connector\Identity\Infrastructure\UI\GraphQL\UserType
	 */
	private $userType;

	public function __construct(UserType $userType)
	{
		$this->userType = $userType;
	}

	public function __invoke(): array
	{
		return [
			'user' => [
				'type' => $this->userType->__invoke(),
				'args' => [
					'id' => [
						'name' => 'id',
						'description' => 'The ID of the data source.',
						'type' => Definition\Type::nonNull(
							Definition\Type::string()
						),
					],
				],
				'resolve' => function ($obj, $args, \Nette\Security\User $context) {
//					return $this->dataSourceRepository->ofId(
//						DataSourceId::createFromString($args['id'])
//					);
					return [];
				},
			],
		];
	}

}
