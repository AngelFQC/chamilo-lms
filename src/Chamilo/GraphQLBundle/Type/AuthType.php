<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\GraphQLBundle\Context;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Class AuthType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class AuthType extends ObjectType
{
    /**
     * AuthType constructor.
     */
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
                'gcmSenderId' => [
                    'description' => 'Sender ID of Firebase Console for Cloud Messaging',
                    'type' => Type::string(),
                ],
            ],
            'resolveField' => function ($token, array $args, Context $context, ResolveInfo $info) {
                $method = 'resolve'.ucfirst($info->fieldName);

                return $this->$method($token, $args, $context, $info);
            },
        ];

        parent::__construct($config);
    }

    /**
     * @param string      $token
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    private function resolveToken($token, array $args, Context $context, ResolveInfo $info)
    {
        return $token;
    }

    /**
     * @param string      $token
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    private function resolveGcmSenderId($token, array $args, Context $context, ResolveInfo $info)
    {
        return api_get_setting('messaging_gdc_project_number');
    }
}
