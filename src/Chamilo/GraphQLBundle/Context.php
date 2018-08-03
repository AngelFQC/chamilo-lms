<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle;

use Chamilo\CoreBundle\Entity\Course;
use Chamilo\UserBundle\Entity\User;

/**
 * Class Context
 *
 * @package Chamilo\GraphQLBundle
 */
class Context
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Course
     */
    private $course;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Context
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     *
     * @return Context
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function requireAuthorization()
    {
        $httpHeaders = apache_request_headers();
        $header = isset($httpHeaders['Authorization']) ? $httpHeaders['Authorization'] : null;
        $token = str_replace('Bearer ', '', $header);

        if (!$token) {
            throw new \Exception(get_lang('NotAllowed'));
        }

        $tokenData = Auth::getTokenData($token);

        $this->user = \UserManager::getManager()->find($tokenData['user']);

        if (!$this->user) {
            throw new \Exception(get_lang('NotAllowed'));
        }
    }
}
