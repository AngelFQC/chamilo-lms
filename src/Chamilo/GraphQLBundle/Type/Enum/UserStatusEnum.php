<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Enum;

use GraphQL\Type\Definition\EnumType;

/**
 * Class UserStatusEnum
 *
 * @package Chamilo\GraphQLBundle\Type\Enum
 */
class UserStatusEnum extends EnumType
{
    const TEACHER = 1;
    const SESSION_ADMIN = 3;
    const DRH = 4;
    const STUDENT = 5;

    /**
     * UserStatusEnum constructor.
     */
    public function __construct()
    {
        $config = [
            'values' => [
                'TEACHER' => [
                    'value' => self::TEACHER,
                    'description' => 'Global status of a user: Course Manager',
                ],
                'SESSION_ADMIN' => [
                    'value' => self::SESSION_ADMIN,
                    'description' => 'Global status of a user: Session Admin',
                ],
                'DRH' => [
                    'value' => self::DRH,
                    'description' => 'Global status of a user: Human Ressource Manager',
                ],
                'STUDENT' => [
                    'value' => self::STUDENT,
                    'description' => 'Global status of a user: Student',
                ],
            ],
        ];

        parent::__construct($config);
    }
}
