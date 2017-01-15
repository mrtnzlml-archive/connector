<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\DomainModel;
use GraphQL\Type\Definition;

class QueryDefinitions implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\UserType
	 */
	private $userType;

	/**
	 * @var \Adeira\Connector\Authentication\DomainModel\User\IUserRepository
	 */
	private $userRepository;

	public function __construct(UserType $userType, DomainModel\User\IUserRepository $userRepository)
	{
		$this->userType = $userType;
		$this->userRepository = $userRepository;
	}

	public function __invoke(): array
	{
		return [
			'user' => [
				'type' => $this->userType,
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
					return $this->userRepository->ofId(
						DomainModel\User\UserId::createFromString($args['id'])
					);
				},
			],
		];
	}

}
