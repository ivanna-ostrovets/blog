<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$postService->addLike($_GET['post_id'], $_GET['user_id']);
