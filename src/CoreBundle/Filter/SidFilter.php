<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

namespace Chamilo\CoreBundle\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Serializer\Filter\FilterInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

class SidFilter extends AbstractFilter
{
    /**
     * @inheritDoc
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'sid' => [
                'property' => null,
                'type' => 'string',
                'required' => false,
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
    ): void {
        if ('search' !== $property) {
            return;
        }

        $alias = $queryBuilder->getAllAliases()[0];
    }
}
