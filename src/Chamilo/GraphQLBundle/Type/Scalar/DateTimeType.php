<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type\Scalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;

/**
 * Class DateTimeType
 *
 * @package Chamilo\GraphQLBundle\Type\Scalar
 */
class DateTimeType extends ScalarType
{

    /**
     * @var string
     */
    public $description = 'Date and time in UTC.';

    /**
     * Serializes an internal value to include in a response.
     *
     * @param string|\DateTime $value
     *
     * @return mixed
     * @throws Error
     */
    public function serialize($value)
    {
        if (!($value instanceof \DateTime)) {
            $value = $this->parseValue($value);
        } else {
            if ($value->getTimezone()->getName() !== 'UTC') {
                $value->setTimezone(new \DateTimeZone('UTC'));
            }
        }

        return $value->format(\DateTime::ATOM);
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * In the case of an invalid value this method must throw an Exception
     *
     * @param mixed $value
     *
     * @return \DateTime
     * @throws Error
     */
    public function parseValue($value)
    {
        if (!is_string($value)) {
            throw new Error("Cannot represent value as date: ".Utils::printSafe($value));
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value, new \DateTimeZone('UTC'));

        return $date;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input
     *
     * In the case of an invalid node or value this method must throw an Exception
     *
     * @param Node       $valueNode
     * @param array|null $variables
     *
     * @return mixed
     * @throws Error
     */
    public function parseLiteral($valueNode, array $variables = null)
    {
        if (!($valueNode instanceof StringValueNode)) {
            throw new Error('Query error: Can only parse strings got: '.$valueNode->kind, [$valueNode]);
        }

        if (!is_string($valueNode->value)) {
            throw new Error('Not a valid date', [$valueNode]);
        }

        return $valueNode->value;
    }
}
