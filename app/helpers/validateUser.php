<?php

function validateUser($user)
{
    $errors = array();
    $secreatKey = "6LfmYkcpAAAAABJ-ddihcwGn4aWRRmgdKoIvq6yd";
//    $secreatKey = "6Ldu1E0pAAAAAFSqu1Fxu85tvVp3LmZqKrYnoB-G";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    unset($_POST['g-recaptcha-response']);

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secreatKey&response=$response&remoteip=$ip";
    $fire = file_get_contents($url);
    $data = json_decode($fire);
    if($data->success == false){
        array_push($errors, 'Recaptcha is required');
    }

    if (empty($user['username'])) {
        array_push($errors, 'Username is required');
    }

    if (empty($user['email'])) {
        array_push($errors, 'Email is required');
    }

    if (empty($user['password'])) {
        array_push($errors, 'Password is required');
    }

    if ($user['passwordConf'] !== $user['password']) {
        array_push($errors, 'Password do not match');
    }

    // $existingUser = selectOne('users', ['email' => $user['email']]);
    // if ($existingUser) {
    //     array_push($errors, 'Email already exists');
    // }

    $existingUser = selectOne('users', ['email' => $user['email']]);
    if ($existingUser) {
        if (isset($user['update-user']) && $existingUser['id'] != $user['id']) {
            array_push($errors, 'Email already exists');
        }

        if (isset($user['create-admin'])) {
            array_push($errors, 'Email already exists');
        }
    }

    return $errors;
}


function validateLogin($user)
{
    $errors = array();
    $secreatKey = "6LfmYkcpAAAAABJ-ddihcwGn4aWRRmgdKoIvq6yd";
//    $secreatKey = "6Ldu1E0pAAAAAFSqu1Fxu85tvVp3LmZqKrYnoB-G";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secreatKey&response=$response&remoteip=$ip";
    $fire = file_get_contents($url);
    $data = json_decode($fire);
    if($data->success == false){
        array_push($errors, 'Recaptcha is required');
    }
    if (empty($user['username'])) {
        array_push($errors, 'Username is required');
    }

    if (empty($user['password'])) {
        array_push($errors, 'Password is required');
    }

    return $errors;
}

// Password validation while changing password
function validatePassword($user)
{
    $errors = array();
    $secreatKey = "6LfmYkcpAAAAABJ-ddihcwGn4aWRRmgdKoIvq6yd";
//    $secreatKey = "6Ldu1E0pAAAAAFSqu1Fxu85tvVp3LmZqKrYnoB-G";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secreatKey&response=$response&remoteip=$ip";
    $fire = file_get_contents($url);
    $data = json_decode($fire);
    if($data->success == false){
        array_push($errors, 'Recaptcha is required');
    }
    if (empty($user['password'])) {
        array_push($errors, 'Password is required');
    }

//    if (strlen($user['password']) < 8) {
//        array_push($errors, 'Password must be at least 8 characters long');
//    }

    if ($user['passwordConf'] !== $user['password']) {
        array_push($errors, 'Password and confirmation password do not match');
    }

    return $errors;
}
