<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Root;

use GraphQL\Type\Definition\ObjectType;

/**
 * Class Mutation
 *
 * @package Chamilo\GraphQLBundle\Type\Root
 */
class Mutation extends ObjectType
{
    /**
     * Mutation constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'Chamilo GraphQL mutations',
            'fields' => [],
            'resolveField' => function ($val, array $args, Context $context, ResolveInfo $info) {
                try {
                    return $this->{$info->fieldName}($val, $args, $context, $info);
                } catch (\Exception $e) {
                    throw new Error($e->getMessage());
                }
            },
        ];

        parent::__construct($config);
    }
}
