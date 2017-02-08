<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/commentService.php');

$commentService->deleteComment($_GET['comment_id']);

header("Location: ../views/showPost.php?id={$_GET['post_id']}");