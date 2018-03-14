<?php
/**
 * @license see /license.txt
 */

use Chamilo\UserBundle\Entity\User;
use Chamilo\CoreBundle\Entity\Course;
use Chamilo\CoreBundle\Entity\Session;
use Chamilo\CoreBundle\Entity\Portfolio;

require_once __DIR__.'/../inc/global.inc.php';

api_block_anonymous_users();

$em = Database::getManager();

$currentUserId = api_get_user_id();
$userId = isset($_GET['user']) ? intval($_GET['user']) : $currentUserId;
/** @var User $user */
$user = api_get_user_entity($userId);
/** @var Course $course */
$course = $em->find('ChamiloCoreBundle:Course', api_get_course_int_id());
/** @var Session $session */
$session = $em->find('ChamiloCoreBundle:Session', api_get_session_id());

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$baseUrl = api_get_self().'?'.api_get_cidreq();
$allowEdit = $currentUserId == $user->getId();

$toolName = get_lang('Portfolio');
$actions = [];
$content = '';

/**
 * Check if the portfolio item is valid for the current user
 * @param \Chamilo\CoreBundle\Entity\Portfolio $item
 * @return bool
 */
$isValid = function (Portfolio $item) use ($user, $course, $session) {
    if (!$item) {
        return false;
    }

    if ($session && $item->getSession()->getId() != $session->getId()) {
        return false;
    }

    if ($course && $item->getCourse()->getId() != $course->getId()) {
        return false;
    }

    if ($item->getUser()->getId() != $user->getId()) {
        return false;
    }

    return true;
};

switch ($action) {
    case 'add_item':
        require 'add_item.php';
        break;
    case 'edit_item':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$id) {
            break;
        }

        /** @var CPortfolio $item */
        $item = $em->find('ChamiloCoreBundle:Portfolio', $id);

        if (!$isValid($item)) {
            api_not_allowed(true);
        }

        require 'edit_item.php';
        break;
    case 'hide_item':
        //no break
    case 'show_item':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$id) {
            break;
        }

        /** @var CPortfolio $item */
        $item = $em->find('ChamiloCoreBundle:Portfolio', $id);

        if (!$isValid($item)) {
            api_not_allowed(true);
        }

        $item->setIsVisible(!$item->isVisible());

        $em->persist($item);
        $em->flush();

        Display::addFlash(
            Display::return_message(get_lang('VisibilityChanged'), 'success')
        );

        header("Location: $baseUrl");
        exit;
    case 'delete_item':
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$id) {
            break;
        }

        /** @var CPortfolio $item */
        $item = $em->find('ChamiloCoreBundle:Portfolio', $id);

        if (!$isValid($item)) {
            api_not_allowed(true);
        }

        $em->remove($item);
        $em->flush();

        Display::addFlash(
            Display::return_message(get_lang('PortfolioItemDeleted'), 'success')
        );

        header("Location: $baseUrl");
        exit;
    case 'list':
        //no break
    default:
        require 'list.php';
}

/*
 * View
 */
$this_section = $course ? SECTION_COURSES : SECTION_SOCIAL;

$actions = implode(PHP_EOL, $actions);

Display::display_header($toolName);
Display::display_introduction_section(TOOL_PORTFOLIO);
echo Display::toolbarAction('portfolio-toolbar', [$actions]);
echo Display::page_header($toolName);
echo $content;
Display::display_footer();
