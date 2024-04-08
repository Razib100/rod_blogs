<?php


function validateBanner($post)
{
    $errors = array();

    if (empty($post['title'])) {
        array_push($errors, 'Title is required');
    }

    return $errors;
}