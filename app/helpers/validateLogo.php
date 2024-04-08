<?php


function validateLogo($post)
{
    $errors = array();

    if (empty($post['title'])) {
        array_push($errors, 'Title is required');
    }
//    if (empty($_FILES['image']['name'])) {
//        array_push($errors, "Logo image is required");
//    }

    return $errors;
}