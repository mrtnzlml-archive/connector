<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints\Infrastructure\Delivery\Http;

use Adeira\Connector\Authentication\DomainModel\{
	ITokenStrategy,
	User\NullUserId,
	User\UserId
};
use Adeira\Connector\GraphQL;
use Nette\Application\Responses\JsonResponse;
use Nette\Http;
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
	 * @var \Nette\Http\IResponse
	 */
	private $httpResponse;

	/**
	 * @var ITokenStrategy
	 */
	private $tokenStrategy;

	public function __construct(
		GraphQL\SchemaFactory $schemaFactory,
		Http\IRequest $httpRequest,
		Http\IResponse $response,
		ITokenStrategy $tokenStrategy
	) {
		$this->schemaFactory = $schemaFactory;
		$this->httpRequest = $httpRequest;
		$this->httpResponse = $response;
		$this->tokenStrategy = $tokenStrategy;
	}

	public function run(\Nette\Application\Request $request)//: ?\Nette\Application\IResponse
	{
		$httpRequest = $this->httpRequest;
		if ($httpRequest->isMethod(Http\IRequest::POST)) {
			$userId = NULL;

			$authHeader = $httpRequest->getHeader('authorization');
			if ($authHeader) {
				$jwtToken = $authHeader;
				$payload = $this->tokenStrategy->decodeToken($jwtToken);
				$userId = $payload->uuid; //TODO: check validity (exp - token is no longer valid)
			}

			// http://graphql.org/learn/serving-over-http/#post-request
			$queryData = Json::decode($httpRequest->getRawBody(), Json::FORCE_ARRAY);
			$requestString = $queryData['query'];
			$variableValues = $queryData['variables'] ?? [];

			$graphResponse = \GraphQL\GraphQL::execute(
				$this->schemaFactory->build(),
				$requestString,
				NULL,
				$userId ? UserId::createFromString($userId) : NullUserId::create(),
				$variableValues
			);
			if (isset($graphResponse['errors'])) {
				$this->httpResponse->setCode(Http\IResponse::S422_UNPROCESSABLE_ENTITY);
			}
			return new JsonResponse($graphResponse);
		} elseif ($httpRequest->isMethod(Http\IRequest::OPTIONS)) {
			return NULL; //terminate
		} else {
			return new GraphQL\Bridge\Application\Responses\GraphqlErrorResponse(
				$httpRequest->getMethod() . ' method is not allowed.',
				Http\IResponse::S405_METHOD_NOT_ALLOWED
			);
		}
	}

}
