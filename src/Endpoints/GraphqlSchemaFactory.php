<?php declare(strict_types = 1);

namespace Adeira\Connector\Endpoints;

use GraphQL\Schema;
use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class GraphqlSchemaFactory
{

	public static function build()
	{
		/**
		 * interface InboundSource {
		 *     id: String!
		 * }
		 */
		$inboundSourceInterface = new InterfaceType([
			'name' => 'InboundSource',
			'description' => 'An inbound data source.',
			'fields' => [
				'id' => [
					'type' => Type::nonNull(Type::string()),
					'description' => 'The id of the inbound data source.',
				],
			],
		]);

		/**
		 * type Device_1 : InboundSource {
		 *     id: String!
		 * }
		 */
		$deviceType = new ObjectType([
			'name' => 'Device_1',
			'description' => 'An inbound data source of concrete type.',
			'fields' => [
				'id' => [
					'type' => new NonNull(Type::string()),
					'description' => 'The id of the device.',
				],
				'name' => [
					'type' => Type::string(),
				],
			],
			'interfaces' => [$inboundSourceInterface],
		]);

		/**
		 * This is the type that will be the root of our query, and the
		 * entry point into our schema.
		 *
		 * type Query {
		 *     device(id: String!): InboundSource
		 * }
		 */
		$queryType = new ObjectType([
			'name' => 'Query',
			'fields' => [
				'device' => [ //TODO: devices
					'type' => $deviceType,
					'args' => [
						'id' => [
							'name' => 'id',
							'description' => 'id of the device',
							'type' => Type::nonNull(Type::string()),
						],
					],
					'resolve' => function ($root, $args) {
						return [
							'id' => $args['id'],
							'name' => 'TODO',
						];
					},
				],
			],
		]);

		/**
		 * input DeviceInput {
		 * }
		 */
		$mutationType = new ObjectType([
			'name' => 'Mutation',
			'fields' => [
				'device' => [
					'type' => $deviceType,
					'args' => [
						'id' => [
							'name' => 'id',
							'description' => 'id of the device',
							'type' => Type::nonNull(Type::string()),
						],
					],
					'resolve' => function ($root, $args) {
						\Tracy\Debugger::log($args);
					},
				],
			],
		]);

		return new Schema([
			'query' => $queryType,
			'mutation' => $mutationType,
		]);
	}

}
