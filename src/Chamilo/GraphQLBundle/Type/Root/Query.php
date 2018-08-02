<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Root;

use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
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
            'fields' => [
                'viewer' => [
                    'description' => 'Get information from current user',
                    'type' => Types::user(),
                ],
            ],
            'resolveField' => function ($val, array $args, Context $context, ResolveInfo $info) {
                $method = 'resolve'.ucfirst($info->fieldName);

                return $this->$method($val, $args, $context, $info);
            },
        ];

        parent::__construct($config);
    }

    /**
     * @param mixed       $value
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return int
     * @throws \Exception
     */
    public function resolveViewer($value, array $args, Context $context, ResolveInfo $info)
    {
        try {
            $context->requireAuthorization();
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }

        return $context->getUser()->getId();
    }
}
