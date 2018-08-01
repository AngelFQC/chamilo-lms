<?php
/* For licensing terms, see /license.txt */

require_once __DIR__.'/../../inc/global.inc.php';

use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

$context = new Context();

try {
    $schema = new Schema(
        [
            'query' => Types::query(),
            'mutation' => Types::mutation(),
        ]
    );

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true) ?: [];
    $input += ['query' => null, 'variables' => null];

    $result = GraphQL::executeQuery(
        $schema,
        $input['query'],
        null,
        $context,
        $input['variables']
    );
    $output = $result->toArray();
} catch (Exception $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage(),
            ],
        ],
    ];
}

header('Content-Type: application/json; charset=UTF-8');

echo json_encode($output);
