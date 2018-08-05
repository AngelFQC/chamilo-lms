<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle;

use Chamilo\GraphQLBundle\Type\AuthType;
use Chamilo\GraphQLBundle\Type\CourseType;
use Chamilo\GraphQLBundle\Type\Enum\ImageSizeEnum;
use Chamilo\GraphQLBundle\Type\Enum\UserStatusEnum;
use Chamilo\GraphQLBundle\Type\MessageType;
use Chamilo\GraphQLBundle\Type\Root\Mutation;
use Chamilo\GraphQLBundle\Type\Root\Query;
use Chamilo\GraphQLBundle\Type\Scalar\DateTimeType;
use Chamilo\GraphQLBundle\Type\SessionCategoryType;
use Chamilo\GraphQLBundle\Type\SessionType;
use Chamilo\GraphQLBundle\Type\UserType;

class Types
{
    /**
     * @var Query
     */
    private static $query;

    /**
     * @var Mutation
     */
    private static $mutation;

    /**
     * @var AuthType
     */
    private static $auth;

    /**
     * @var UserType
     */
    private static $user;

    /**
     * @var UserStatusEnum
     */
    private static $userStatusEnum;

    /**
     * @var ImageSizeEnum
     */
    private static $imageSizeEnum;

    /**
     * @var MessageType
     */
    private static $message;

    /**
     * @var DateTimeType
     */
    private static $dateTime;

    /**
     * @var CourseType
     */
    private static $course;

    /**
     * @var SessionType
     */
    private static $session;

    /**
     * @var SessionCategoryType
     */
    private static $sessionCategory;

    /**
     * @return Query
     */
    public static function query()
    {
        if (!self::$query) {
            self::$query = new Query();
        }

        return self::$query;
    }

    /**
     * @return Mutation
     */
    public static function mutation()
    {
        if (!self::$mutation) {
            self::$mutation = new Mutation();
        }

        return self::$mutation;
    }

    /**
     * @return AuthType
     */
    public static function auth()
    {
        if (!self::$auth) {
            self::$auth = new AuthType();
        }

        return self::$auth;
    }

    /**
     * @return UserType
     */
    public static function user()
    {
        if (!self::$user) {
            self::$user = new UserType();
        }

        return self::$user;
    }

    /**
     * @return UserStatusEnum
     */
    public static function userStatusEnum()
    {
        if (!self::$userStatusEnum) {
            self::$userStatusEnum = new UserStatusEnum();
        }

        return self::$userStatusEnum;
    }

    /**
     * @return ImageSizeEnum
     */
    public static function imageSizeEnum()
    {
        if (!self::$imageSizeEnum) {
            self::$imageSizeEnum = new ImageSizeEnum();
        }

        return self::$imageSizeEnum;
    }

    /**
     * @return MessageType
     */
    public static function message()
    {
        if (!self::$message) {
            self::$message = new MessageType();
        }

        return self::$message;
    }

    /**
     * @return DateTimeType
     */
    public static function dateTime()
    {
        if (!self::$dateTime) {
            self::$dateTime = new DateTimeType();
        }

        return self::$dateTime;
    }

    /**
     * @return CourseType
     */
    public static function course()
    {
        if (!self::$course) {
            self::$course = new CourseType();
        }

        return self::$course;
    }

    /**
     * @return SessionType
     */
    public static function session()
    {
        if (!self::$session) {
            self::$session = new SessionType();
        }

        return self::$session;
    }

    /**
     * @return SessionCategoryType
     */
    public static function sessionCategory()
    {
        if (!self::$sessionCategory) {
            self::$sessionCategory = new SessionCategoryType();
        }

        return self::$sessionCategory;
    }
}
