<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/scripts/thumbnailCreate.php');

$title = $_POST['title'];
$teaser = $_POST['teaser'];
$content = $_POST['content'];
$category = $_POST['category'];

$errors = array();

if (!empty($_FILES['image']['tmp_name'])) {
  $imagePath = '/public/posts_images/' . basename($_FILES["image"]["name"]);
  $imageFileType = pathinfo($imagePath, PATHINFO_EXTENSION);

  if ($imageFileType == "jpg"
    || $imageFileType == "png"
    || $imageFileType == "jpeg"
    || $imageFileType == "gif"
  ) {
    if (getimagesize($_FILES["image"]["tmp_name"]) === FALSE) {
      $errors[] = array("message" => "File is not an image.");
    } else {
      if (!move_uploaded_file($_FILES["image"]["tmp_name"], realpath($_SERVER["DOCUMENT_ROOT"]) . $imagePath)) {
        $errors[] = array("message" => "Sorry, there was an error uploading your file.");
      } else {
        thumbnailCreate(realpath($_SERVER["DOCUMENT_ROOT"]) . $imagePath);
      }
    }
  } else {
    $errors[] = array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
  }
} else {
  $imagePath = "";
}

if (empty($category)) {
  $errors[] = array("message" => "Please select category.");
}

if (empty($content)) {
  $errors[] = array("message" => "Please fill out content field.");
}

if (empty($teaser)) {
  $teaser = mb_substr($content, 0, 100) . "...";
}

if (empty($errors)) {
  try {
    $postService->createPost($title, $category, $teaser, $content, $imagePath);
  } catch (Exception $e) {
    $errors[] = array("message" => $e->getMessage());
  }
}

if (!empty($errors)) {
  echo json_encode(array('errors' => $errors));
  http_response_code(400);
}
