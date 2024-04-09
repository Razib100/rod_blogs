<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validateLogo.php");

$table = 'logo';
$logos = selectAll($table);
$logo = getLogo();

$errors = array();
$id = "";
$title = "";
$image = "";
$status = "";

if (isset($_GET['id'])) {
    $banner = selectOne($table, ['id' => $_GET['id']]);

    $id = $banner['id'];
    $title = $banner['title'];
    $image = $banner['image'];
    $status = $banner['status'];
}

if (isset($_GET['delete_id'])) {
    adminOnly();
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "Logo deleted successfully";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/logo/index.php");
    exit();
}

if (isset($_GET['status']) && isset($_GET['p_id'])) {
    adminOnly();
    $status = $_GET['status'];
    $p_id = $_GET['p_id'];
    $count = update($table, $p_id, ['status' => $status]);
    $_SESSION['message'] = "Banner status state changed!";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/banner/index.php");
    exit();
}



if (isset($_POST['add-logo'])) {
    adminOnly();
    $errors = validateLogo($_POST);

    if (count($errors) == 0) {
        unset($_POST['add-logo']);
        $_POST['status'] = isset($_POST['status']) ? 1 : 0;
        if (!empty($_FILES['image']['name'])) {
            $image_name = time() . '_' . $_FILES['image']['name'];
            $destination = ROOT_PATH . "/assets/images/" . $image_name;

            $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

            if ($result) {
                $_POST['image'] = $image_name;
            } else {
                array_push($errors, "Failed to upload image");
            }
        }
//        else{
//            array_push($errors, "Logo image is required");
//        }
        $logo_id = create($table, $_POST);
        $_SESSION['message'] = "Logo created successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/logo/index.php");
        exit();
    } else {
        $title = $_POST['title'];
        $image = $_POST['image'];
//        array_push($errors, "Logo image is required");
        $status = isset($_POST['status']) ? 1 : 0;
    }
}


if (isset($_POST['update-logo'])) {
    adminOnly();
    $errors = validateLogo($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed to upload image");
        }
    }

    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-logo'], $_POST['id']);
        $_POST['status'] = isset($_POST['status']) ? 1 : 0;
        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = "Logo updated successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/logo/index.php");
    } else {
        $title = $_POST['title'];
        $image = $_POST['image'];
        $status = isset($_POST['status']) ? 1 : 0;
    }

}