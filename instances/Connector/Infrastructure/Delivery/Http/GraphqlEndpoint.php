<?php declare(strict_types = 1);

namespace Adeira\Connector\Infrastructure\Delivery\Http;

use Adeira\Connector\Authentication\DomainModel\{
	User\NullUserId, User\UserId
};
use Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\JwtOwnerService;
use Adeira\Connector\GraphQL\Context;
use Adeira\Connector\GraphQL\Infrastructure\Delivery\Http\Nette\GraphqlErrorResponse;
use Adeira\Connector\GraphQL\SchemaFactory;
use GraphQL\Validator\DocumentValidator;
use Nette\Application\Responses\JsonResponse;
use Nette\Http;
use Nette\Utils\Json;

final class GraphqlEndpoint implements \Nette\Application\IPresenter
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
	 * @var \Adeira\Connector\Authentication\Infrastructure\DomainModel\Owner\JwtOwnerService
	 */
	private $ownerService;

	public function __construct(
		SchemaFactory $schemaFactory,
		Http\IRequest $httpRequest,
		JwtOwnerService $ownerService
	) {
		$this->schemaFactory = $schemaFactory;
		$this->httpRequest = $httpRequest;
		$this->ownerService = $ownerService;
	}

	public function run(\Nette\Application\Request $request): ?\Nette\Application\IResponse
	{
		$httpRequest = $this->httpRequest;
		if ($httpRequest->isMethod(Http\IRequest::POST)) {
			$userId = \Ramsey\Uuid\Uuid::NIL;

			// get user UUID from authorization header
			$jwtToken = $httpRequest->getHeader('authorization');
			if ($jwtToken) {
				$owner = $this->ownerService->ownerFrom($jwtToken);
				if ($owner !== NULL) {
					$userId = (string)$owner->id();
				}
			}

			// parse JSON from raw POST body
			try {
				$rawBody = $httpRequest->getRawBody();
				if ($rawBody === NULL) {
					return $this->error('Recieved POST body empty. Please send me valid JSON.');
				}
				$queryData = Json::decode($rawBody, Json::FORCE_ARRAY);
				if (!isset($queryData['query'])) {
					return $this->error("Request mush have 'query' field with GraphQL query.");
				}
				$requestString = $queryData['query'];
				$variableValues = $queryData['variables'] ?? NULL;
				$operationName = $queryData['operationName'] ?? NULL;
			} catch (\Nette\Utils\JsonException $exc) {
				return $this->error('Recieved POST body is not in valid JSON format.');
			}

			/**
			 * @var \GraphQL\Validator\Rules\QueryComplexity $queryComplexity
			 * @var \GraphQL\Validator\Rules\QueryDepth $queryDepth
			 */
			$queryComplexity = DocumentValidator::getRule('QueryComplexity');
			$queryDepth = DocumentValidator::getRule('QueryDepth');
			$queryComplexity->setMaxQueryComplexity($maxQueryComplexity = 200); //introspection complexity is 181
			$queryDepth->setMaxQueryDepth($maxQueryDepth = 11); //introspection depth is 11

			// execute GraphQL query
			$graphResponse = \GraphQL\GraphQL::executeAndReturnResult(
				$this->schemaFactory->build(),
				$requestString,
				NULL,
				new Context($userId ? UserId::createFromString($userId) : NullUserId::create()),
				$variableValues,
				$operationName
			);

			// forward to the Error presenter
			if (!empty($graphResponse->errors)) {
				$request->setPresenterName('Connector:GraphqlError');
				$request->setMethod(\Nette\Application\Request::FORWARD);
				$request->setParameters(['exception' => $graphResponse]);
				return new \Nette\Application\Responses\ForwardResponse($request);
			}

			// return JSON response
			return new JsonResponse(['data' => $graphResponse->data]);
		} elseif ($httpRequest->isMethod(Http\IRequest::OPTIONS)) {
			return NULL; //terminate
		} else {
			return $this->error(
				$httpRequest->getMethod() . ' method is not allowed. Use POST instead.',
				Http\IResponse::S405_METHOD_NOT_ALLOWED
			);
		}
	}

	private function error(string $message, int $httpCode = Http\IResponse::S422_UNPROCESSABLE_ENTITY)
	{
		return new GraphqlErrorResponse($message, $httpCode);
	}

}
