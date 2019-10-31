<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\PluginBundle\MigrationMoodle\Task;

use Chamilo\PluginBundle\MigrationMoodle\Extractor\BaseExtractor;
use Chamilo\PluginBundle\MigrationMoodle\Loader\CoursesLoader;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\BaseTransformer;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\Property\CourseCategoryLookup;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\Property\CourseVisibilityLookup;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\Property\DateTimeObject;
use Chamilo\PluginBundle\MigrationMoodle\Transformer\Property\IsFalse;

/**
 * Class CoursesTask.
 *
 * @package Chamilo\PluginBundle\MigrationMoodle\Task
 */
class CoursesTask extends BaseTask
{
    /**
     * @return array
     */
    public function getExtractConfiguration(): array
    {
        return [
            'class' => BaseExtractor::class,
            'query' => 'SELECT * FROM mdl_course',
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
                'title' => 'fullname',
                'visual_code' => 'shortname',
                'category_code' => [
                    'class' => CourseCategoryLookup::class,
                    'properties' => ['category'],
                ],
                'course_language' => 'lang',
                'visibility' => [
                    'class' => CourseVisibilityLookup::class,
                    'properties' => ['visible'],
                ],
                'subscribe' => [
                    'class' => IsFalse::class,
                    'properties' => [],
                ],
                'unsubscribe' => [
                    'class' => IsFalse::class,
                    'properties' => [],
                ],
                'description' => 'summary',
                'creation_date' => [
                    'class' => DateTimeObject::class,
                    'properties' => ['timecreated'],
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
            'class' => CoursesLoader::class,
        ];
    }
}
