<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Type\Enum\ImageSizeEnum;
use Chamilo\GraphQLBundle\Types;
use Chamilo\UserBundle\Entity\User;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Class UserType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class UserType extends ObjectType
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserType constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'User.',
            'fields' => [
                'id' => Type::int(),
                'firstName' => Type::string(),
                'lastName' => Type::string(),
                'username' => Type::string(),
                'status' => Types::userStatusEnum(),
                'email' => Type::string(),
                'officialCode' => Type::string(),
                'picture' => [
                    'type' => Type::string(),
                    'args' => [
                        'size' => [
                            'type' => Types::imageSizeEnum(),
                            'defaultValue' => ImageSizeEnum::SIZE_MEDIUM,
                        ],
                    ],
                ],
                'messages' => [
                    'description' => 'Received messages for the user.',
                    'type' => Type::listOf(
                        Types::message()
                    ),
                    'args' => [
                        'lastId' => [
                            'description' => 'Last received by the app message ID.',
                            'type' => Type::int(),
                            'defaultValue' => 0,
                        ],
                    ],
                ],
                'courses' => [
                    'description' => 'Course list for the current user.',
                    'type' => Type::listOf(
                        Types::course()
                    ),
                ],
            ],
            'resolveField' => function ($userId, array $args, Context $context, ResolveInfo $info) {
                if (!$this->user ||
                    ($this->user && $this->user->getId() != $userId)
                ) {
                    $this->user = \Database::getManager()->find('ChamiloUserBundle:User', $userId);
                }

                $method = 'resolve'.ucfirst($info->fieldName);

                if (method_exists($this, $method)) {
                    return $this->{$method}($userId, $args, $context, $info);
                }

                $method = 'get'.ucfirst($info->fieldName);

                if (method_exists($this->user, $method)) {
                    return $this->user->{$method}();
                }

                return null;
            },
        ];

        parent::__construct($config);
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    protected function resolveEmail($userId, array $args, Context $context, ResolveInfo $info)
    {
        $showEmail = $this->user->getId() === $context->getUser()->getId() ||
            api_get_setting('show_email_addresses') === 'true';

        if ($showEmail) {
            return $this->user->getEmail();
        }

        return '';
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    protected function resolvePicture($userId, array $args, Context $context, ResolveInfo $info)
    {
        $pictureInfo = \UserManager::getUserPicture(
            $this->user->getId(),
            $args['size']
        );

        return $pictureInfo;
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     * @throws Error
     */
    protected function resolveMessages($userId, array $args, Context $context, ResolveInfo $info)
    {
        $user = $context->getUser();

        if ($userId != $user->getId()) {
            throw new Error(get_lang('UserInfoDoesNotMatch'));
        }

        $messagesInfo = \MessageManager::getMessagesFromLastReceivedMessage(
            $userId,
            $args['lastId']
        );

        $result = [];

        foreach ($messagesInfo as $messageInfo) {
            $result[] = [
                'id' => $messageInfo['id'],
                'title' => $messageInfo['title'],
                'content' => $messageInfo['content'],
                'sender' => $messageInfo['user_sender_id'],
                'sendDate' => $messageInfo['send_date'],
                'hasAttachments' => \MessageManager::hasAttachments($messageInfo['id']),
            ];
        }

        return $result;
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     * @throws Error
     */
    protected function resolveCourses($userId, array $args, Context $context, ResolveInfo $info)
    {
        if ($userId != $context->getUser()->getId()) {
            throw new Error(get_lang('UserInfoDoesNotMatch'));
        }

        $coursesInfo = \CourseManager::get_courses_list_by_user_id($this->user->getId());

        $ids = array_column($coursesInfo, 'real_id');

        return array_map('intval', $ids);
    }
}
