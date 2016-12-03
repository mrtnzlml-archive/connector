<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use Adeira\Connector\GraphQL;
use Nette\Application\Responses\JsonResponse;
use Nette\Http;
use Nette\Security\User;
use Nette\Utils\Json;

class GraphqlEndpoint implements \Nette\Application\IPresenter
{

	/**
	 * @var \Adeira\Connector\GraphQL\SchemaFactory
	 */
	private $schemaFactory;

	/**
	 * @var \Nette\Http\IRequest
	 */
	private $httpRequest;

	/**
	 * @var \Nette\Security\User
	 */
	private $user;

	public function __construct(GraphQL\SchemaFactory $schemaFactory, Http\IRequest $httpRequest, User $user)
	{
		$this->schemaFactory = $schemaFactory;
		$this->httpRequest = $httpRequest;
		$this->user = $user;
	}

	public function run(\Nette\Application\Request $request): \Nette\Application\IResponse
	{
		//TODO: check Authorization header (only if application service throw unauthorized exception)!

		$httpRequest = $this->httpRequest;
		if ($httpRequest->isMethod(Http\IRequest::POST)) {
			// http://graphql.org/learn/serving-over-http/#post-request
			$queryData = Json::decode($httpRequest->getRawBody(), Json::FORCE_ARRAY);
			$requestString = $queryData['query'];
			$variableValues = $queryData['variables'] ?? [];

			return new JsonResponse(\GraphQL\GraphQL::execute( //FIXME retur 500 is error (?)
				$this->schemaFactory->build(),
				$requestString,
				NULL,
				$this->user,
				$variableValues
			));
		} elseif ($httpRequest->isMethod(Http\IRequest::OPTIONS)) {
			return new JsonResponse([':)']); //FIXME: what is the right response?
		} else {
			return new GraphQL\Bridge\Application\Responses\GraphqlErrorResponse(
				$httpRequest->getMethod() . ' method is not allowed.',
				Http\IResponse::S405_METHOD_NOT_ALLOWED
			);
		}
	}

}
