<?php
/* For licensing terms, see /license.txt */

$actions[] = Display::url(
    Display::return_icon('add.png', get_lang('Add'), [], ICON_SIZE_MEDIUM),
    "$baseUrl&action=add_item"
);

$criteria = ['user' => $user];

if ($course) {
    $criteria['course'] = $course;
    $criteria['session'] = $session;
}

$portfolio = $em
    ->getRepository('ChamiloCoreBundle:Portfolio')
    ->findBy($criteria);

$template = new Template(null, false, false, false, false, false, false);
$template->assign('allow_edit', $allowEdit);
$template->assign('portfolio', $portfolio);
$layout = $template->get_template('portfolio/list.html.twig');
$content = $template->fetch($layout);
