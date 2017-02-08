<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$postService->deleteLike($_GET['post_id'], $_GET['user_id']);
