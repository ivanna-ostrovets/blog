<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/db/database.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/scripts/thumbnailCreate.php');

$title = $_POST['title'];
$teaser = $_POST['teaser'];
$content = $_POST['content'];
$category = $_POST['category'];

if (!empty($_FILES['image']['tmp_name'])) {
  $imagePath = '/public/posts_images/' . basename($_FILES["image"]["name"]);
  $imageFileType = pathinfo($imagePath, PATHINFO_EXTENSION);

  $errors = array();

  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    $errors[] = array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
  }

  if (getimagesize($_FILES["image"]["tmp_name"]) === FALSE) {
    $errors[] = array("message" => "File is not an image.");
  }

  if (!move_uploaded_file($_FILES["image"]["tmp_name"], realpath($_SERVER["DOCUMENT_ROOT"]) . $imagePath)) {
    $errors[] = array("message" => "Sorry, there was an error uploading your file.");
  } else {
    thumbnailCreate(realpath($_SERVER["DOCUMENT_ROOT"]) . $imagePath);
  }
} else {
  $imagePath = 0;
}

if (empty($category)) {
  $errors[] = array("message" => "Please, select category.");
}

if (empty($errors)) {
  try {
    $postService->editPost($_GET['id'], $title, $category, $teaser, $content, $imagePath);
  } catch (Exception $e) {
    $errors[] = array("message" => $e->getMessage());
  }
}

if (!empty($errors)) {
  echo json_encode(array('errors' => $errors));
  http_response_code(400);
}

//if (isset($_POST['delete_image']))  {
//  $imagePath = '/public/posts_images/' . basename($_FILES["image"]["name"]);
//  $uploadOk = 1;
//  $imageFileType = pathinfo($imagePath, PATHINFO_EXTENSION);
//
//  $errors = array();
//
//  if (!empty($_FILES['image']['tmp_name'])) {
//    if (isset($_POST["submit"])) {
//      if (getimagesize($_FILES["image"]["tmp_name"]) !== FALSE) {
//        $uploadOk = 1;
//      }
//      else {
//        $errors[] = "File is not an image.";
//        $uploadOk = 0;
//      }
//    }
//
//    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//      && $imageFileType != "gif"
//    ) {
//      $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//      $uploadOk = 0;
//    }
//
//    if ($uploadOk == 0) {
//      $errors[] = "Sorry, your file was not uploaded.";
//    }
//    else {
//      if (!move_uploaded_file($_FILES["image"]["tmp_name"], realpath($_SERVER["DOCUMENT_ROOT"]) . $imagePath)) {
//        $errors[] = "Sorry, there was an error uploading your file.";
//      }
//      else {
//        thumbnailCreate(realpath($_SERVER["DOCUMENT_ROOT"]) . $imagePath);
//      }
//    }
//  }
//  else {
//    $imagePath = $postService->defaultImagePath;
//  }
//}
//else {
//  $imagePath = 0;
//}
//
//$postId = $_GET['id'];
//$postService->editPost($postId, $title, $category, $teaser, $content, $imagePath);