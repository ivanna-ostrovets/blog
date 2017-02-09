<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

echo json_encode($postService->toggleLike($_GET['post_id'], $_GET['user_id']));
