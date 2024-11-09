<?php
// index.php
require 'core/View.php';
require 'controllers/PostController.php';

$controller = new PostController();
$controller->index();
