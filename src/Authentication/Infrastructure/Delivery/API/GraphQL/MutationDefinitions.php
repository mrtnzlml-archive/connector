<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL;

use Adeira\Connector\Authentication\Application\Service\SignInService;
use GraphQL\Type\Definition\Type;

class MutationDefinitions implements \Adeira\Connector\GraphQL\IMutationDefinition
{

	/**
	 * @var \Adeira\Connector\Authentication\Application\Service\SignInService
	 */
	private $signInService;

	/**
	 * @var \Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\UserType
	 */
	private $userType;

	public function __construct(SignInService $signInService, UserType $userType)
	{
		$this->signInService = $signInService;
		$this->userType = $userType;
	}

	public function __invoke(): array
	{
		return [
			'login' => [
				'type' => $this->userType->__invoke(),
				'args' => [
					'username' => [
						'name' => 'username',
						'description' => 'Username of the user',
						'type' => Type::nonNull(Type::string()),
					],
					'password' => [
						'name' => 'password',
						'description' => 'Password of the user',
						'type' => Type::nonNull(Type::string()),
					],
				],
				'resolve' => function ($root, $args) {
					return $this->signInService->execute($args['username'], $args['password']);
				},
			],
		];
	}

}
