<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\GraphQLBundle\Type;

use Chamilo\GraphQLBundle\Context;
use Chamilo\GraphQLBundle\Type\Enum\ImageSizeEnum;
use Chamilo\GraphQLBundle\Types;
use Chamilo\UserBundle\Entity\User;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

/**
 * Class UserType
 *
 * @package Chamilo\GraphQLBundle\Type
 */
class UserType extends ObjectType
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserType constructor.
     */
    public function __construct()
    {
        $config = [
            'description' => 'User.',
            'fields' => [
                'id' => Type::int(),
                'firstName' => Type::string(),
                'lastName' => Type::string(),
                'username' => Type::string(),
                'status' => Types::userStatusEnum(),
                'email' => Type::string(),
                'officialCode' => Type::string(),
                'picture' => [
                    'type' => Type::string(),
                    'args' => [
                        'size' => [
                            'type' => Types::imageSizeEnum(),
                            'defaultValue' => ImageSizeEnum::SIZE_MEDIUM,
                        ],
                    ],
                ],
                'messages' => [
                    'description' => 'Received messages for the user.',
                    'type' => Type::listOf(
                        Types::message()
                    ),
                    'args' => [
                        'lastId' => [
                            'description' => 'Last received by the app message ID.',
                            'type' => Type::int(),
                            'defaultValue' => 0,
                        ],
                    ],
                ],
                'courses' => [
                    'description' => 'Course list for the current user.',
                    'type' => Type::listOf(
                        Types::course()
                    ),
                ],
                'sessions' => [
                    'description' => 'Session list for the current user.',
                    'type' => Type::listOf(
                        Types::session()
                    ),
                ],
            ],
            'resolveField' => function ($userId, array $args, Context $context, ResolveInfo $info) {
                if (!$this->user ||
                    ($this->user && $this->user->getId() != $userId)
                ) {
                    $this->user = \Database::getManager()->find('ChamiloUserBundle:User', $userId);
                }

                $method = 'resolve'.ucfirst($info->fieldName);

                if (method_exists($this, $method)) {
                    return $this->{$method}($userId, $args, $context, $info);
                }

                $method = 'get'.ucfirst($info->fieldName);

                if (method_exists($this->user, $method)) {
                    return $this->user->{$method}();
                }

                return null;
            },
        ];

        parent::__construct($config);
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    protected function resolveEmail($userId, array $args, Context $context, ResolveInfo $info)
    {
        $showEmail = $this->user->getId() === $context->getUser()->getId() ||
            api_get_setting('show_email_addresses') === 'true';

        if ($showEmail) {
            return $this->user->getEmail();
        }

        return '';
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return string
     */
    protected function resolvePicture($userId, array $args, Context $context, ResolveInfo $info)
    {
        $pictureInfo = \UserManager::getUserPicture(
            $this->user->getId(),
            $args['size']
        );

        return $pictureInfo;
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     * @throws Error
     */
    protected function resolveMessages($userId, array $args, Context $context, ResolveInfo $info)
    {
        $user = $context->getUser();

        if ($userId != $user->getId()) {
            throw new Error(get_lang('UserInfoDoesNotMatch'));
        }

        $messagesInfo = \MessageManager::getMessagesFromLastReceivedMessage(
            $userId,
            $args['lastId']
        );

        $result = [];

        foreach ($messagesInfo as $messageInfo) {
            $result[] = [
                'id' => $messageInfo['id'],
                'title' => $messageInfo['title'],
                'content' => $messageInfo['content'],
                'sender' => $messageInfo['user_sender_id'],
                'sendDate' => $messageInfo['send_date'],
                'hasAttachments' => \MessageManager::hasAttachments($messageInfo['id']),
            ];
        }

        return $result;
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     * @throws Error
     */
    protected function resolveCourses($userId, array $args, Context $context, ResolveInfo $info)
    {
        if ($userId != $context->getUser()->getId()) {
            throw new Error(get_lang('UserInfoDoesNotMatch'));
        }

        $coursesInfo = \CourseManager::get_courses_list_by_user_id($this->user->getId());

        $ids = array_column($coursesInfo, 'real_id');

        return array_map('intval', $ids);
    }

    /**
     * @param int         $userId
     * @param array       $args
     * @param Context     $context
     * @param ResolveInfo $info
     *
     * @return array
     * @throws Error
     */
    public function resolveSessions($userId, array $args, Context $context, ResolveInfo $info)
    {
        if ($userId != $context->getUser()->getId()) {
            throw new Error(get_lang('UserInfoDoesNotMatch'));
        }

        $results = [];

        $allowOrder = api_get_configuration_value('session_list_order');
        $showAllSessions = api_get_configuration_value('show_all_sessions_on_my_course_page') === true;
        $orderBySettings = api_get_configuration_value('my_courses_session_order');

        $position = '';

        if ($allowOrder) {
            $position = ', s.position AS position ';
        }

        $now = api_get_utc_datetime(null, false, true);

        $dql = "SELECT DISTINCT
                    s.id,
                    s.accessEndDate AS access_end_date,
                    s.duration,
                    CASE WHEN s.accessEndDate IS NULL THEN 1 ELSE 0 END HIDDEN _isFieldNull
                    $position
                FROM ChamiloCoreBundle:Session AS s
                LEFT JOIN ChamiloCoreBundle:SessionRelCourseRelUser AS scu WITH scu.session = s
                INNER JOIN ChamiloCoreBundle:AccessUrlRelSession AS url WITH url.sessionId = s.id
                LEFT JOIN ChamiloCoreBundle:SessionCategory AS sc WITH s.category = sc
                WHERE (scu.user = :user OR s.generalCoach = :user) AND url.accessUrlId = :url";

        $order = "ORDER BY sc.name, s.name";

        if ($showAllSessions) {
            $order = "ORDER BY s.accessStartDate";
        }

        if ($allowOrder) {
            $order = "ORDER BY s.position";
        }

        if (!empty($orderBySettings) && isset($orderBySettings['field']) && isset($orderBySettings['order'])) {
            $field = $orderBySettings['field'];
            $orderSetting = $orderBySettings['order'];

            switch ($field) {
                case 'start_date':
                    $order = "ORDER BY s.accessStartDate $orderSetting";
                    break;
                case 'end_date':
                    $order = " ORDER BY s.accessEndDate $orderSetting ";
                    if ($orderSetting == 'asc') {
                        // Put null values at the end
                        // https://stackoverflow.com/questions/12652034/how-can-i-order-by-null-in-dql
                        $order = "ORDER BY _isFieldNull asc, s.accessEndDate asc";
                    }
                    break;
            }
        }

        $sessions = \Database::getManager()
            ->createQuery("$dql $order")
            ->setParameters(
                [
                    'user' => $this->user->getId(),
                    'url' => api_get_current_access_url_id(),
                ]
            )
            ->getResult();

        foreach ($sessions as $row) {
            $coachList = \SessionManager::getCoachesBySession($row['id']);
            $courseList = \UserManager::get_courses_list_by_session(
                $this->user->getId(),
                $row['id']
            );
            $daysLeft = \SessionManager::getDayLeftInSession(
                ['id' => $row['id'], 'duration' => $row['duration']],
                $this->user->getId()
            );

            $isGeneralCoach = \SessionManager::user_is_general_coach($this->user->getId(), $row['id']);
            $isCoachOfCourse = in_array($this->user->getId(), $coachList);

            if (!$isGeneralCoach && !$isCoachOfCourse) {
                // Teachers can access the session depending in the access_coach date
                if ($row['duration']) {
                    if ($daysLeft <= 0) {
                        continue;
                    }
                } else {
                    if (isset($row['access_end_date']) && !empty($row['access_end_date'])) {
                        if ($row['access_end_date'] <= $now) {
                            continue;
                        }
                    }
                }
            }

            $visibility = api_get_session_visibility($row['id'], null, false);

            if ($visibility != SESSION_VISIBLE) {
                // Course Coach session visibility.
                $blockedCourseCount = 0;
                $closedVisibilityList = [COURSE_VISIBILITY_CLOSED, COURSE_VISIBILITY_HIDDEN];

                $sessionCourseVisibility = SESSION_INVISIBLE;

                foreach ($courseList as $course) {
                    // Checking session visibility
                    $sessionCourseVisibility = api_get_session_visibility(
                        $row['id'],
                        $course['real_id'],
                        false
                    );

                    $courseIsVisible = !in_array($course['visibility'], $closedVisibilityList);

                    if ($courseIsVisible === false || $sessionCourseVisibility == SESSION_INVISIBLE) {
                        $blockedCourseCount++;
                    }
                }

                // If all courses are blocked then no show in the list.
                if ($blockedCourseCount !== count($courseList)) {
                    $visibility = $sessionCourseVisibility;
                }
            }

            if ($visibility == SESSION_INVISIBLE) {
                continue;
            }

            $results[] = $row['id'];
        }

        return $results;
    }
}
