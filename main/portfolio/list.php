<?php
/* For licensing terms, see /license.txt */

$actions[] = Display::url(
    Display::return_icon('add.png', get_lang('Add'), [], ICON_SIZE_MEDIUM),
    $baseUrl.'action=add_item'
);
$actions[] = Display::url(
    Display::return_icon('folder.png', get_lang('AddCategory'), [], ICON_SIZE_MEDIUM),
    $baseUrl.'action=add_category'
);

$criteria = ['user' => $user];

$categories = $em
    ->getRepository('ChamiloCoreBundle:PortfolioCategory')
    ->findBy($criteria);

if ($course) {
    $criteria['course'] = $course;
    $criteria['session'] = $session;
}

$criteria['category'] = null;

$items = $em
    ->getRepository('ChamiloCoreBundle:Portfolio')
    ->findBy($criteria);

$template = new Template(null, false, false, false, false, false, false);
$template->assign('course', $course);
$template->assign('session', $session);
$template->assign('allow_edit', $allowEdit);
$template->assign('portfolio', $categories);
$template->assign('uncategorized_items', $items);
$layout = $template->get_template('portfolio/list.html.twig');
$content = $template->fetch($layout);
