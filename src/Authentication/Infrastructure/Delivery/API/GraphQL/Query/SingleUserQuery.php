<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\Query;

use Adeira\Connector\Authentication\DomainModel;
use Adeira\Connector\GraphQL\Context;

final class SingleUserQuery
{

	private $userRepository;

	public function __construct(DomainModel\User\IUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function __invoke($ancestorValue, $args, Context $context)
	{
		return $this->userRepository->ofId(
			DomainModel\User\UserId::createFromString($args['id'])
		);
	}

}
