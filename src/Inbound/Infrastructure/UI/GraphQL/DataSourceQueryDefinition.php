<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\UI\GraphQL;

use Adeira\Connector\Identity\DomainModel\User\UserId;
use Adeira\Connector\Inbound\Application\Service\DataSource\ViewAllDataSourcesService;
use Adeira\Connector\Inbound\Application\Service\DataSource\ViewSingleDataSourceService;
use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use GraphQL\Type\Definition;

class DataSourceQueryDefinition implements \Adeira\Connector\GraphQL\IQueryDefinition
{

	/**
	 * @var \Adeira\Connector\Inbound\Application\Service\DataSource\ViewAllDataSourcesService
	 */
	private $allDataSourcesService;

	/**
	 * @var \Adeira\Connector\Inbound\Application\Service\DataSource\ViewSingleDataSourceService
	 */
	private $singleDataSourceService;

	public function __construct(
		ViewAllDataSourcesService $allDataSourcesService,
		ViewSingleDataSourceService $singleDataSourceService
	) {
		$this->allDataSourcesService = $allDataSourcesService;
		$this->singleDataSourceService = $singleDataSourceService;
	}

	/**
	 * device(id: String!): InboundSource
	 */
	public function __invoke(): array
	{
		$dataSourceType = (new DataSourceType)(); //FIXME: singleton
		return [
			'device' => [
				'type' => $dataSourceType,
				'args' => [
					'id' => [
						'name' => 'id',
						'description' => 'The ID of the data source.',
						'type' => Definition\Type::nonNull(
							Definition\Type::string()
						),
					],
				],
				'resolve' => function ($obj, $args, UserId $userId) {
					return $this->singleDataSourceService->execute(
						$userId,
						DataSourceId::createFromString($args['id'])
					);
				},
			],
			'devices' => [
				'type' => Definition\Type::listOf($dataSourceType),
				'resolve' => function ($obj, $args, UserId $userId) {
					return $this->allDataSourcesService->execute($userId);
				},
			],
		];
	}

}
