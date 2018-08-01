<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class AuthType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class AuthType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'description' => 'Authorization response',
            'fields' => [
                'token' => [
                    'description' => 'Authorization token',
                    'type' => Type::nonNull(
                        Type::string()
                    ),
                ],
            ],
        ];

        parent::__construct($config);
    }
}
