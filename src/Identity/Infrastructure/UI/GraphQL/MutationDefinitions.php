<?php declare(strict_types = 1);

namespace Adeira\Connector\Identity\Infrastructure\UI\GraphQL;

use Adeira\Connector\Identity\Application\Service\SignInService;
use GraphQL\Type\Definition\Type;

class MutationDefinitions implements \Adeira\Connector\GraphQL\IMutationDefinition
{

	/**
	 * @var \Adeira\Connector\Identity\Application\Service\SignInService
	 */
	private $signInService;

	/**
	 * @var \Adeira\Connector\Identity\Infrastructure\UI\GraphQL\UserType
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
