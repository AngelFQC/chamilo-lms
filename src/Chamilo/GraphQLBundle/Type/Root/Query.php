<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Root;

use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
use Chamilo\UserBundle\Entity\User;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

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
                'messageContacts' => [
                    'description' => 'Get potential users to send a message for the current user.',
                    'type' => Type::listOf(
                        Types::user()
                    ),
                    'args' => [
                        'text' => [
                            'description' => 'The search text to filter the user list.',
                            'type' => Type::nonNull(
                                Type::string()
                            ),
                        ],
                    ],
                ],
                'course' => [
                    'description' => 'Get information about a course '
                        .'(only for platform admins or user subscribed to course).',
                    'type' => Types::course(),
                    'args' => [
                        'id' => [
                            'type' => Type::nonNull(
                                Type::int()
                            ),
                        ],
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

    /**
     * @param mixed       $value
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return int
     * @throws Error
     */
    public function resolveCourse($value, array $args, Context $context, ResolveInfo $info)
    {
        try {
            $context->requireAuthorization();
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }

        $courseId = (int) $args['id'];

        if (!$context->userIsAllowedToCourse($courseId)) {
            throw new Error(get_lang('NotAllowed'));
        }

        return $courseId;
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
    protected function resolveMessageContacts($value, array $args, Context $context, ResolveInfo $info)
    {
        try {
            $context->requireAuthorization();
        } catch (\Exception $e) {
            throw new Error($e->getMessage());
        }

        $text = $args['text'];

        if (strlen($text) <= 1) {
            return [];
        }

        $users = \UserManager::getRepository()
            ->findUsersToSendMessage($context->getUser()->getId(), $text);

        $list = [];

        /** @var User $user */
        foreach ($users as $user) {
            $list[] = $user->getId();
        }

        return $list;
    }
}
