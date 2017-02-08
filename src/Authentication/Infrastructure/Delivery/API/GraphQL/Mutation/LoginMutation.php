<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\Mutation;

use Adeira\Connector\Authentication\Application\Service\SignInService;
use Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\UserType;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Structure\Argument;
use function Adeira\Connector\GraphQL\string;
use GraphQL\Type\Definition\ObjectType;

final class LoginMutation extends \Adeira\Connector\GraphQL\Structure\Query
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

	public function getPublicQueryName(): string
	{
		return 'login';
	}

	public function getPublicQueryDescription(): string
	{
		return 'Allows user login via username and password.';
	}

	public function getQueryReturnType(): ObjectType
	{
		return \Adeira\Connector\GraphQL\type($this->userType);
	}

	public function defineArguments(): ?array
	{
		return [
			new Argument('username', 'Username of the user', string()),
			new Argument('password', 'Password of the user', string()),
		];
	}

	public function resolve($ancestorValue, $args, Context $context)
	{
		return $this->signInService->execute($args['username'], $args['password']);
	}

}
