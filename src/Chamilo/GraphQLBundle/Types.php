<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle;

use Chamilo\GraphQLBundle\Type\Root\Mutation;
use Chamilo\GraphQLBundle\Type\Root\Query;

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
}
