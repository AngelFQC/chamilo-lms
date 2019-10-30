<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\PluginBundle\MigrationMoodle\Task;

use Chamilo\PluginBundle\MigrationMoodle\Extractor\BaseExtractor;
use Chamilo\PluginBundle\MigrationMoodle\Loader\CourseCategoriesLoader;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\BaseTransformer;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\Property\CodeLookup;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\Property\CourseCategoryParentLookup;

/**
 * Class CourseCategoriesTask.
 *
 * @package Chamilo\PluginBundle\MigrationMoodle\Task
 */
class CourseCategoriesTask extends BaseTask
{
    /**
     * @return array
     */
    public function getExtractConfiguration(): array
    {
        return [
            'class' => BaseExtractor::class,
            'query' => 'SELECT * FROM mdl_course_categories ORDER BY parent ASC, id ASC',
        ];
    }

    /**
     * @return array
     */
    public function getTransformConfiguration(): array
    {
        return [
            'class' => BaseTransformer::class,
            'map' => [
                'name' => 'name',
                'code' => [
                    'class' => CodeLookup::class,
                    'properties' => ['name'],
                ],
                'description' => 'description',
                'parent_id' => [
                    'class' => CourseCategoryParentLookup::class,
                    'properties' => ['parent'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getLoadConfiguration(): array
    {
        return [
            'class' => CourseCategoriesLoader::class,
        ];
    }
}
