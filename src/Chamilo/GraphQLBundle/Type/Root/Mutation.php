<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Root;

use Chamilo\GraphQLBundle\Auth;
use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

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
            'description' => 'GraphQL mutations',
            'fields' => [
                'authenticate' => [
                    'description' => 'Authenticate user',
                    'type' => Types::auth(),
                    'args' => [
                        'username' => Type::nonNull(
                            Type::string()
                        ),
                        'password' => Type::nonNull(
                            Type::string()
                        ),
                    ],
                ],
                'saveGCMId' => [
                    'description' => 'Save client ID for push notifications.',
                    'type' => Type::boolean(),
                    'args' => [
                        'registrationId' => Type::nonNull(
                            Type::string()
                        ),
                    ],
                ],
                'sendMessage' => [
                    'type' => Type::listOf(
                        Type::boolean()
                    ),
                    'args' => [
                        'receivers' => [
                            'description' => 'IDs of users who will receive the message.',
                            'type' => Type::nonNull(
                                Type::listOf(
                                    Type::int()
                                )
                            ),
                        ],
                        'subject' => Type::nonNull(
                            Type::string()
                        ),
                        'text' => Type::nonNull(
                            Type::string()
                        ),
                    ],
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
     * Authenticate user by username and password.
     *
     * @param string      $value
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     * @throws Error
     */
    protected function resolveAuthenticate($value, array $args, Context $context, ResolveInfo $info)
    {
        $username = $args['username'];
        $password = $args['password'];

        try {
            $token = Auth::validateUser($username, $password);

            return $token;
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }
    }

    /**
     * @param mixed       $value
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return mixed
     * @throws Error
     */
    protected function resolveSaveGCMId($value, array $args, Context $context, ResolveInfo $info)
    {
        try {
            $context->requireAuthorization();
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }

        $registrationId = \Security::remove_XSS($args['registrationId']);
        $extraFieldValue = new \ExtraFieldValue('user');

        $saved = $extraFieldValue->save(
            [
                'variable' => \Rest::EXTRA_FIELD_GCM_REGISTRATION,
                'value' => $registrationId,
                'item_id' => $context->getUser()->getId(),
            ]
        );

        return (bool) $saved;
    }

    /**
     * @param mixed       $value
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     * @throws Error
     */
    protected function resolveSendMessage($value, array $args, Context $context, ResolveInfo $info)
    {
        try {
            $context->requireAuthorization();
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }

        $receivers = $args['receivers'];
        $subject = $args['subject'];
        $text = $args['text'];

        $list = [];

        foreach ($receivers as $userId) {
            $list[] = (bool) \MessageManager::send_message(
                $userId,
                $subject,
                $text,
                [],
                [],
                [],
                0,
                0,
                0,
                $context->getUser()->getId()
            );
        }

        return $list;
    }
}
