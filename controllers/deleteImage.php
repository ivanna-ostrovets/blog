<?php
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/services/postService.php');

$postService->deleteImage($_GET['id']);