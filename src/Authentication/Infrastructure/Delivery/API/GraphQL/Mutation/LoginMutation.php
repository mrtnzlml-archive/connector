<?php declare(strict_types = 1);

namespace Adeira\Connector\Authentication\Infrastructure\Delivery\API\GraphQL\Mutation;

use Adeira\Connector\Authentication\Application\Service\SignInService;
use Adeira\Connector\GraphQL\Context;

final class LoginMutation
{

	/**
	 * @var \Adeira\Connector\Authentication\Application\Service\SignInService
	 */
	private $signInService;

	public function __construct(SignInService $signInService)
	{
		$this->signInService = $signInService;
	}

	public function __invoke($ancestorValue, $args, Context $context)
	{
		return $this->signInService->execute($args['username'], $args['password']);
	}

}
