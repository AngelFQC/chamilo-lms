<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Class MessageType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class MessageType extends ObjectType
{
    const EXCERPT_LENGTH = 50;

    /**
     * MessageType constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'Received message by user',
            'fields' => function () {
                return [
                    'id' => Type::int(),
                    'title' => Type::string(),
                    'sender' => Types::user(),
                    'sendDate' => Types::dateTime(),
                    'content' => Type::string(),
                    'excerpt' => [
                        'type' => Type::string(),
                        'args' => [
                            'length' => [
                                'description' => 'The approximate desired length. '
                                    .self::EXCERPT_LENGTH.' chars by default.',
                                'type' => Type::int(),
                                'default' => self::EXCERPT_LENGTH,
                            ],
                        ],
                    ],
                    'hasAttachments' => Type::boolean(),
                ];
            },
            'resolveField' => function ($value, array $args, Context $context, ResolveInfo $info) {
                $method = 'resolve'.ucfirst($info->fieldName);

                if (method_exists($this, $method)) {
                    return $this->$method($value, $args, $context, $info);
                }

                return $value[$info->fieldName];
            },
        ];

        parent::__construct($config);
    }

    /**
     * @param array       $value
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    private function resolveContent($value, array $args, Context $context, ResolveInfo $info)
    {
        return $value['content'];
    }

    /**
     * @param array       $value
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    private function resolveExcerpt($value, array $args, Context $context, ResolveInfo $info)
    {
        $args = array_merge(
            ['length' => self::EXCERPT_LENGTH],
            $args
        );

        $cleanContent = strip_tags($value['content']);
        $cleanContent = str_replace(["\r\n", "\n"], ' ', $cleanContent);
        $cleanContent = trim($cleanContent);

        return api_trunc_str($cleanContent, $args['length']);
    }
}
