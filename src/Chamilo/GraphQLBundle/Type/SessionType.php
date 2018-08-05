<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\CoreBundle\Entity\Session;
use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Class SessionType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class SessionType extends ObjectType
{
    /**
     * @var Session
     */
    private $session;

    /**
     * SessionType constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'Session.',
            'fields' => function () {
                return [
                    'id' => Type::int(),
                    'name' => Type::string(),
                    'category' => Types::sessionCategory(),
                    'description' => Type::string(),
                    'showDescription' => Type::boolean(),
                    'numberOfCourses' => Type::int(),
                    'numberOfUsers' => Type::int(),
                    'duration' => Type::int(),
                    'displayStartDate' => Types::dateTime(),
                    'displayEndDate' => Types::dateTime(),
                    'accessStartDate' => Types::dateTime(),
                    'accessEndDate' => Types::dateTime(),
                    'coachAccessStartDate' => Types::dateTime(),
                    'coachAccessEndDate' => Types::dateTime(),
                    'generalCoach' => Types::user(),
                ];
            },
            'resolveField' => function ($sessionId, array $args, Context $context, ResolveInfo $info) {
                if (!$this->session ||
                    ($this->session && $this->session->getId() != $sessionId)
                ) {
                    $this->session = \Database::getManager()->find('ChamiloCoreBundle:Session', $sessionId);

                    if (!$this->session) {
                        throw new Error(get_lang('NoSession'));
                    }

                    $context->setSession($this->session);
                }

                $method = 'resolve'.ucfirst($info->fieldName);

                if (method_exists($this, $method)) {
                    return $this->$method($sessionId, $args, $context, $info);
                }

                $method = 'get'.ucfirst($info->fieldName);

                if (method_exists($this->session, $method)) {
                    return $this->session->$method();
                }

                return null;
            },
        ];

        parent::__construct($config);
    }

    /**
     * @param int         $sessionId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return mixed
     */
    protected function resolveCategory($sessionId, array $args, Context $context, ResolveInfo $info)
    {
        return $this->session->getCategory()->getId();
    }

    /**
     * @param int         $sessionId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return int
     */
    protected function resolveNumberOfCourses($sessionId, array $args, Context $context, ResolveInfo $info)
    {
        return $this->session->getNbrCourses();
    }

    /**
     * @param int         $sessionId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return int
     */
    protected function resolveNumberOfUsers($sessionId, array $args, Context $context, ResolveInfo $info)
    {
        return $this->session->getNbrUsers();
    }

    /**
     * @param int         $sessionId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return int
     */
    protected function resolveGeneralCoach($sessionId, array $args, Context $context, ResolveInfo $info)
    {
        return $this->session->getGeneralCoach()->getId();
    }
}
