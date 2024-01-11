<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

namespace Chamilo\CoreBundle\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

class CidFilter extends AbstractFilter
{
    /**
     * @inheritDoc
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'cid' => [
                'property' => null,
                'type' => 'string',
                'required' => true,
                'description' => 'Course identifier',
            ],
        ];
    }

    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ) {
        // TODO: Implement filterProperty() method.
    }
}
