<?php declare(strict_types = 1);

namespace Adeira\Connector\Inbound\Infrastructure\UI\GraphQL;

use Adeira\Connector\Inbound\DomainModel\DataSource\DataSource;
use Adeira\Connector\Inbound\DomainModel\DataSource\DataSourceId;
use Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository;
use GraphQL\Type\Definition;

class DataSourceType implements \Adeira\Connector\GraphQL\IType
{

	/**
	 * @var \Adeira\Connector\Inbound\DomainModel\DataSource\IDataSourceRepository
	 */
	private $dataSourceRepository;

	public function __construct(IDataSourceRepository $dataSourceRepository)
	{
		$this->dataSourceRepository = $dataSourceRepository;
	}

	/**
	 * type Device_1 : DataSource {
	 *     id: String!
	 * }
	 */
	public function getTypeDefinition(): Definition\ObjectType
	{
		return new Definition\ObjectType([
			'name' => 'DataSource',
			'description' => 'An inbound data source.',
			'fields' => [
				'id' => [
					'type' => new Definition\NonNull(
						Definition\Type::string()
					),
					'description' => 'The ID of the data source.',
					'resolve' => function (DataSource $obj, $args, $context) {
						return $obj->id();
					},
				],
				'name' => [
					'type' => new Definition\NonNull(
						Definition\Type::string()
					),
					'description' => 'Name of the data source.',
					'resolve' => function (DataSource $obj, $args, $context) {
						return $obj->deviceName();
					},
				],
				'records' => [
					'type' => Definition\Type::listOf(
						Definition\Type::string() //FIXME: DataSourceRecordTypes
					),
					'description' => 'Records of the data source.',
					'args' => [
						'first' => [ // length from beginning
							'type' => Definition\Type::int(),
							'defaultValue' => 1000,
						],
					],
					'resolve' => function (DataSource $obj, $args, $context) {
						$data = ['abc', 'xyz']; //TODO: records (record ID + data)
						return array_slice($data, 0, $args['first']);
					},
				],
			],
		]);
	}

	/**
	 * device(id: String!): InboundSource
	 */
	public function getPublicTypeDefinition(): array
	{
		return [
			'device' => [
				'type' => $this->getTypeDefinition(),
				'args' => [
					'id' => [
						'name' => 'id',
						'description' => 'The ID of the data source.',
						'type' => Definition\Type::nonNull(
							Definition\Type::string()
						),
					],
				],
				'resolve' => function ($obj, $args, \Nette\Security\User $context) {
					return $this->dataSourceRepository->ofId(
						DataSourceId::createFromString($args['id'])
					);
				},
			],
		];
	}

	//TODO: mutations

}
