<?php
/* For licensing terms, see /license.txt */

$form = new FormValidator('edit_portfolio', 'post', "$baseUrl&action=edit_item&id={$item->getId()}");
$form->addText('title', get_lang('Title'));
$form->addHtmlEditor('content', get_lang('Content'), true   , false, ['ToolbarSet' => 'NotebookStudent']);
$form->addButtonUpdate(get_lang('Update'));
$form->setDefaults([
    'title' => $item->getTitle(),
    'content' => $item->getContent()
]);

if ($form->validate()) {
    $values = $form->exportValues();
    $currentTime = new DateTime(api_get_utc_datetime(), new DateTimeZone('UTC'));

    $item
        ->setTitle($values['title'])
        ->setContent($values['content'])
        ->setUpdateDate($currentTime);

    $em->persist($item);
    $em->flush();

    Display::addFlash(
        Display::return_message(get_lang('Updated'), 'success')
    );

    header("Location: $baseUrl");
    exit;
}

$toolName = get_lang('EditPortfolioItem');
$interbreadcrumb[] = [
    'name' => get_lang('Portfolio'),
    'url' => $baseUrl
];
$actions[] = Display::url(
    Display::return_icon('back.png', get_lang('Back'), [], ICON_SIZE_MEDIUM),
    $baseUrl
);
$content = $form->returnForm();
