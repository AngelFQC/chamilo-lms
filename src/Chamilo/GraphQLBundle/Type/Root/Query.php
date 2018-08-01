<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Root;

use Chamilo\GraphQLBundle\Context;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Query
 *
 * @package Chamilo\GraphQLBundle\Type\Root
 */
class Query extends ObjectType
{
    /**
     * Query constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'Chamilo GraphQL queries',
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
