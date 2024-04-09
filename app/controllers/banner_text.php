<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateBannerText.php");

$table = 'banner_text';

$errors = array();
$id = '';
$name = '';
$description = '';

$bannerTexts = selectAll($table);
$logo = getLogo();

if (isset($_POST['add-text'])) {
    adminOnly();
    $errors = validateBannerText($_POST);

    if (count($errors) === 0) {
        unset($_POST['add-text']);
        $_POST['status'] = isset($_POST['status']) ? 1 : 0;
        $_POST['user_id'] = $_SESSION['id'];
        $topic_id = create($table, $_POST);
        $_SESSION['message'] = 'Banner text created successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/banner_text/index.php');
        exit();
    } else {
        $title = $_POST['title'];
        $sub_title = $_POST['sub_title'];
        $status = $_POST['status'];
    }
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $text = selectOne($table, ['id' => $id]);
    $id = $text['id'];
    $title = $text['title'];
    $sub_title = $text['sub_title'];
    $status = $text['status'];
}

if (isset($_GET['del_id'])) {
    adminOnly();
    $id = $_GET['del_id'];
    $count = delete($table, $id);
    $_SESSION['message'] = 'Banner text deleted successfully';
    $_SESSION['type'] = 'success';
    header('location: ' . BASE_URL . '/admin/banner_text/index.php');
    exit();
}


if (isset($_POST['update-bannerText'])) {
    adminOnly();
    $errors = validateBannerText($_POST);

    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-bannerText'], $_POST['id']);
        if(isset($_POST['status']) && !empty(isset($_POST['status'])) && isset($_POST['status']) == 'on'){
            $_POST['status'] = 1;
        }else{
            $_POST['status'] = 0;
        }
        $text_id = update($table, $id, $_POST);
        $_SESSION['message'] = 'Banner text updated successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . BASE_URL . '/admin/banner_text/index.php');
        exit();
    } else {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $sub_title = $_POST['sub_title'];
        $status = $_POST['status'];
    }

}
