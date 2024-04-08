<?php

function validateBannerText($topic)
{
    $errors = array();

    if (empty($topic['title'])) {
        array_push($errors, 'Title is required');
    }
    if (empty($topic['sub_title'])) {
        array_push($errors, 'Sub Title is required');
    }
    $existingText = selectOne('banner_text', ['title' => $topic['title']]);
    if ($existingText) {
        if (isset($topic['update-text']) && $existingText['id'] != $topic['id']) {
            array_push($errors, 'Title already exists');
        }

        if (isset($topic['add-text'])) {
            array_push($errors, 'Title already exists');
        }
    }

    return $errors;
}
