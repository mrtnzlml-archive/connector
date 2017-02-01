<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\Query;

use Adeira\Connector\Authentication\DomainModel;
use Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\UserType;
use Adeira\Connector\GraphQL\Structure\Argument;
use function Adeira\Connector\GraphQL\{
	id, type
};
use GraphQL\Type\Definition;

final class SingleUserQuery extends \Adeira\Connector\GraphQL\Structure\Query
{

	private $userType;

	private $userRepository;

	public function __construct(UserType $userType, DomainModel\User\IUserRepository $userRepository)
	{
		$this->userType = $userType;
		$this->userRepository = $userRepository;
	}

	public function getPublicQueryName(): string
	{
		return 'user';
	}

	public function getPublicQueryDescription(): string
	{
		return 'Single user';
	}

	public function getQueryReturnType(): Definition\ObjectType
	{
		return type($this->userType);
	}

	public function defineArguments(): ?array
	{
		return [
			new Argument('id', 'ID of the user account', id()),
		];
	}

	public function resolve($ancestorValue, $args, DomainModel\User\UserId $userId)
	{
		return $this->userRepository->ofId(
			DomainModel\User\UserId::createFromString($args['id'])
		);
	}

}
