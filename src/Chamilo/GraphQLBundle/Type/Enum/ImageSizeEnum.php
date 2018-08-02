<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Enum;

use GraphQL\Type\Definition\EnumType;

/**
 * Class ImageSizeEnum
 *
 * @package Chamilo\GraphQLBundle\Type\Enum
 */
class ImageSizeEnum extends EnumType
{
    const SIZE_SMALL = 4;
    const SIZE_MEDIUM = 3;
    const SIZE_BIG = 2;

    /**
     * ImageSizeEnum constructor.
     */
    public function __construct()
    {
        $config = [
            'values' => [
                'SIZE_SMALL' => [
                    'value' => self::SIZE_SMALL,
                    'description' => 'Image in small size: 32px',
                ],
                'SIZE_MEDIUM' => [
                    'value' => self::SIZE_MEDIUM,
                    'description' => 'Image in small size: 64px',
                ],
                'SIZE_BIG' => [
                    'value' => self::SIZE_BIG,
                    'description' => 'Image in small size: 128px',
                ]
            ],
        ];

        parent::__construct($config);
    }
}
