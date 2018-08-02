<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Type\Enum\ImageSizeEnum;
use Chamilo\GraphQLBundle\Types;
use Chamilo\UserBundle\Entity\User;
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
                            'default' =>  ImageSizeEnum::SIZE_MEDIUM
                        ],
                    ],
                ],
            ],
            'resolveField' => function ($userId, array $args, Context $context, ResolveInfo $info) {
                if (!$this->user) {
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
    private function resolvePicture($userId, array $args, Context $context, ResolveInfo $info)
    {
        $args = array_merge(
            ['size' => ImageSizeEnum::SIZE_MEDIUM],
            $args
        );

        $pictureInfo = \UserManager::getUserPicture(
            $this->user->getId(),
            $args['size']
        );

        return $pictureInfo;
    }
}
