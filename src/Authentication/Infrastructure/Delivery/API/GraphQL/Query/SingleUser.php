<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\Query;

use Adeira\Connector\Authentication\DomainModel;
use Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\UserType;
use Adeira\Connector\GraphQL\Structure\{
	ArgumentSpecification, FieldSpecification
};
use GraphQL\Type\Definition;

final class SingleUser implements \Adeira\Connector\GraphQL\IQueryDefinition
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
		$userField = new FieldSpecification('user', 'Single user', $this->userType);
		$userField->addArguments(
			new ArgumentSpecification('id', 'ID of the user account', Definition\Type::nonNull(Definition\Type::string()))
		);
		$userField->setResolveFunction(function ($obj, $args, \Nette\Security\User $context) {
			return $this->userRepository->ofId(
				DomainModel\User\UserId::createFromString($args['id'])
			);
		});
		return $userField->buildArray();
	}

}
