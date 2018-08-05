<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\CoreBundle\Entity\Course;
use Chamilo\CoreBundle\Entity\Session;
use Chamilo\CoreBundle\Entity\SessionRelCourseRelUser;
use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Class CourseType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class CourseType extends ObjectType
{
    /**
     * @var Course
     */
    private $course;

    /**
     * CourseType constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'Course.',
            'fields' => function () {
                return [
                    'id' => Type::int(),
                    'title' => Type::string(),
                    'code' => Type::string(),
                    'categoryCode' => Type::string(),
                    'directory' => Type::string(),
                    'picture' => [
                        'type' => Type::string(),
                        'args' => [
                            'fullSize' => [
                                'type' => Type::boolean(),
                                'defaultValue' => false,
                            ],
                        ],
                    ],
                    'teachers' => [
                        'description' => 'Teachers list in base course. Or tutors list from course in session.',
                        'type' => Type::listOf(
                            Types::user()
                        ),
                    ],
                    'tools' => [
                        'description' => 'List of names from available tools for student view.',
                        'type' => Type::listOf(
                            Type::string()
                        ),
                    ],
                ];
            },
            'resolveField' => function ($courseId, array $args, Context $context, ResolveInfo $info) {
                if (!$this->course ||
                    ($this->course && $this->course->getId() != $courseId)
                ) {
                    $this->course = \Database::getManager()->find('ChamiloCoreBundle:Course', $courseId);

                    if (!$this->course) {
                        throw new Error(get_lang('NoCourse'));
                    }
                }

                $context->setCourse($this->course);

                $method = 'resolve'.ucfirst($info->fieldName);

                if (method_exists($this, $method)) {
                    return $this->$method($courseId, $args, $context, $info);
                }

                $method = 'get'.ucfirst($info->fieldName);

                if (method_exists($this->course, $method)) {
                    return $this->course->$method();
                }

                return null;
            },
        ];

        parent::__construct($config);
    }

    /**
     * @param int         $courseId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     */
    protected function resolveTeachers($courseId, array $args, Context $context, ResolveInfo $info)
    {
        $session = $context->getSession();

        if ($session) {
            $result = [];
            $coachSubscriptions = $session->getUserCourseSubscriptionsByStatus($this->course, Session::COACH);

            /** @var SessionRelCourseRelUser $coachSubscription */
            foreach ($coachSubscriptions as $coachSubscription) {
                $result[] = $coachSubscription->getUser()->getId();
            }

            return $result;
        }

        $teachersInfo = \CourseManager::get_teacher_list_from_course_code($this->course->getCode());

        $ids = array_column($teachersInfo, 'user_id');

        return array_map('intval', $ids);
    }

    /**
     * @param int         $courseId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return null|string
     */
    protected function resolvePicture($courseId, array $args, Context $context, ResolveInfo $info)
    {
        return $this
            ->course
            ->getPicturePath(
                (boolean) $args['fullSize']
            );
    }

    /**
     * @param int         $courseId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     */
    protected function resolveTools($courseId, array $args, Context $context, ResolveInfo $info)
    {
        $tools = \CourseHome::get_tools_category(
            TOOL_STUDENT_VIEW,
            $this->course->getId()
        );

        return array_column($tools, 'name');
    }
}
