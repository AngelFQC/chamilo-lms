<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\CoreBundle\Entity\SessionCategory;
use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Class SessionCategoryType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class SessionCategoryType extends ObjectType
{
    /**
     * @var SessionCategory
     */
    private $category;

    /**
     * SessionCategoryType constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'Session category.',
            'fields' => function () {
                return [
                    'id' => Type::int(),
                    'name' => Type::string(),
                    'startDate' => Types::dateTime(),
                    'endDate' => Types::dateTime(),
                ];
            },
            'resolveField' => function ($id, array $args, Context $context, ResolveInfo $info) {
                if (!$this->category ||
                    ($this->category && $this->category->getId() != $id)
                ) {
                    $this->category = \Database::getManager()->find('ChamiloCoreBundle:SessionCategory', $id);

                    if (!$this->category) {
                        throw new Error(get_lang('NotFound'));
                    }
                }

                $method = 'resolve'.ucfirst($info->fieldName);

                if (method_exists($this, $method)) {
                    return $this->$method($id, $args, $context, $info);
                }

                $method = 'get'.ucfirst($info->fieldName);

                if (method_exists($this->category, $method)) {
                    return $this->category->$method();
                }

                return null;
            }
        ];

        parent::__construct($config);
    }

    /**
     * @param int         $id
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return \DateTime
     */
    protected function resolveStartDate($id, array $args, Context $context, ResolveInfo $info)
    {
        return $this->category->getDateStart();
    }

    /**
     * @param int         $id
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return \DateTime
     */
    protected function resolveEndDate($id, array $args, Context $context, ResolveInfo $info)
    {
        return $this->category->getDateEnd();
    }
}
