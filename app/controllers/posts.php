<?php

include(ROOT_PATH . "/app/database/db.php");
include(ROOT_PATH . "/app/helpers/middleware.php");
include(ROOT_PATH . "/app/helpers/validatePost.php");

$table = 'posts';

$topics = selectAll('topics');
$posts = selectAll($table);
$logo = getLogo();

$errors = array();
$id = "";
$title = "";
$body = "";
$topic_id = "";
$published = "";
$tending = "";
$tag = "";

$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);

if (isset($uri_segments[3])) {
	if (isset($_GET['id'])) {
		$post = selectOne($table, ['id' => $_GET['id']]);

		$id = $post['id'];
		$title = $post['title'];
		$body = $post['body'];
		$image = $post['image'];
		$topic_id = $post['topic_id'];
		$published = $post['published'];
		$tending = $post['tending'];
		$tag = $post['tag'];
	}
    function getLastIntegerFromString($str) {
        // Match the last integer in the string (positive only)
        if (preg_match_all('/\b\d+\b/', $str, $matches)) {
            // Get the last match
            $lastInteger = end($matches[0]);
            return intval($lastInteger); // Convert the last match to an integer
        } else {
            return null; // No integer found in the string
        }
      }
      $_GET['id'] = getLastIntegerFromString($uri_segments[3]);
}

if (isset($_GET['id'])) {
    $post = selectOne($table, ['id' => $_GET['id']]);

    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    $image = $post['image'];
    $topic_id = $post['topic_id'];
    $published = $post['published'];
    $tending = $post['tending'];
    $tag = $post['tag'];
}

if (isset($_GET['delete_id'])) {
    adminOnly();
    $count = delete($table, $_GET['delete_id']);
    $_SESSION['message'] = "Post deleted successfully";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php"); 
    exit();
}

if (isset($_GET['published']) && isset($_GET['p_id'])) {
    adminOnly();
    $published = $_GET['published'];
    $p_id = $_GET['p_id'];
    $count = update($table, $p_id, ['published' => $published]);
    $_SESSION['message'] = "Post published state changed!";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php"); 
    exit();
}

if (isset($_GET['tending']) && isset($_GET['p_id'])) {
    adminOnly();
    $tending = $_GET['tending'];
    $p_id = $_GET['p_id'];
    $count = update($table, $p_id, ['tending' => $tending]);
    $_SESSION['message'] = "Post published state changed!";
    $_SESSION['type'] = "success";
    header("location: " . BASE_URL . "/admin/posts/index.php");
    exit();
}



if (isset($_POST['add-post'])) {
    adminOnly();
    $errors = validatePost($_POST);
    $_POST['tending'] = isset($_POST['tending']) ? 1 : 0;
    if($_POST['tending'] == 1) {
        if (!empty($_FILES['image']['name'])) {
            $image_name = time() . '_' . sanitizeFileName($_FILES['image']['name']);
            $destination = ROOT_PATH . "/assets/images/" . $image_name;

            $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

            if ($result) {
                $_POST['image'] = $image_name;
            } else {
                array_push($errors, "Failed to upload image");
            }
        }else{
            array_push($errors, "This is Tending Post image required");
        }
    }
//	if($_POST['tending'] == 1) {
//		if (!empty($_FILES['image']['name'])) {
//			$image_name = time() . '_' . sanitizeFileName($_FILES['image']['name']);
//			$destination = ROOT_PATH . "/assets/images/" . $image_name;
//
//			// Get the uploaded image's temporary location
//			$tmp_location = $_FILES['image']['tmp_name'];
//
//			// Get the original image's dimensions
//			list($width, $height) = getimagesize($tmp_location);
//
//			// Set a maximum width and height for resizing
//			$max_width = 800;
//			$max_height = 600;
//
//			// Calculate new dimensions
//			$ratio = min($max_width/$width, $max_height/$height);
//			$new_width = $width * $ratio;
//			$new_height = $height * $ratio;
//
//			// Create a new image resource with the new dimensions
//			$image_resized = imagecreatetruecolor($new_width, $new_height);
//
//			// Load the original image
//			$image_original = imagecreatefromjpeg($tmp_location); // Change this to appropriate function based on image type
//
//			// Resize the original image to the new dimensions
//			imagecopyresampled($image_resized, $image_original, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
//
//			// Save the resized image
//			$result = imagejpeg($image_resized, $destination); // Change this to appropriate function based on desired image format
//
//			// Free up memory
//			imagedestroy($image_original);
//			imagedestroy($image_resized);
//
//			if ($result) {
//				$_POST['image'] = $image_name;
//			} else {
//				array_push($errors, "Failed to upload image");
//			}
//		}else{
//			array_push($errors, "This is Tending Post image required");
//		}
//	}

	if (isset($_POST['tag']) && $_POST['tag']) {
        $array = json_decode($_POST['tag'], true);

        $values = array();
        foreach ($array as $item) {
            $values[] = $item['value'];
        }

        $result = implode(',', $values);
        $_POST['tag'] = $result;
    }

    if (count($errors) == 0) {
        unset($_POST['add-post']);
        $_POST['user_id'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['view_count'] =  0;
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['tag'] = $_POST['tag'];
    
        $post_id = create($table, $_POST);
        $_SESSION['message'] = "Post created successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php"); 
        exit();    
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
        $tag = $_POST['tag'];
    }
}


if (isset($_POST['update-post'])) {
    adminOnly();
    $errors = validatePost($_POST);

    if (!empty($_FILES['image']['name'])) {
        $image_name = time() . '_' . sanitizeFileName($_FILES['image']['name']);
        $destination = ROOT_PATH . "/assets/images/" . $image_name;

        $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        if ($result) {
            $_POST['image'] = $image_name;
        } else {
            array_push($errors, "Failed to upload image");
        }
    }

    if (isset($_POST['tag']) && $_POST['tag']) {
        $array = json_decode($_POST['tag'], true);

        $values = array();
        foreach ($array as $item) {
            $values[] = $item['value'];
        }

        $result = implode(',', $values);
        $_POST['tag'] = $result;
    }

    if (count($errors) == 0) {
        $id = $_POST['id'];
        unset($_POST['update-post'], $_POST['id']);
        // $_POST['edited_by'] = $_SESSION['id'];
        $_POST['published'] = isset($_POST['published']) ? 1 : 0;
        $_POST['tending'] = isset($_POST['tending']) ? 1 : 0;
        $_POST['body'] = htmlentities($_POST['body']);
        $_POST['tag'] = $_POST['tag'];
    
        $post_id = update($table, $id, $_POST);
        $_SESSION['message'] = "Post updated successfully";
        $_SESSION['type'] = "success";
        header("location: " . BASE_URL . "/admin/posts/index.php");       
    } else {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $topic_id = $_POST['topic_id'];
        $published = isset($_POST['published']) ? 1 : 0;
        $tag = $_POST['tag'];
    }

}

function sanitizeFileName($fileName) {
    // Replace spaces with underscores
    $fileName = str_replace(' ', '_', $fileName);
    
    // Remove any characters that are not alphanumeric, underscore, or dot
    $fileName = preg_replace('/[^\w\-.]/', '', $fileName);
    
    return $fileName;
}