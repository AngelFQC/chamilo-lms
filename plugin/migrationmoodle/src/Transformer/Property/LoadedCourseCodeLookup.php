<?php

namespace Chamilo\PluginBundle\MigrationMoodle\Transformer\Property;

use Chamilo\CoreBundle\Entity\Course;
use Chamilo\CoreBundle\Framework\Container;
use Chamilo\PluginBundle\MigrationMoodle\Task\CoursesTask;

/**
 * Class LoadedCourseCodeLookup.
 *
 * @package Chamilo\PluginBundle\MigrationMoodle\Transformer\Property
 */
class LoadedCourseCodeLookup extends LoadedKeyLookup
{
    /**
     * LoadedCourseCodeLookup constructor.
     */
    public function __construct()
    {
        $this->calledClass = CoursesTask::class;
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     *
     * @return string
     */
    public function transform(array $data)
    {
        $cId = parent::transform($data);

        /** @var Course $course */
        $course = Container::getCourseRepository()->find($cId);

        return $course->getCode();
    }
}
