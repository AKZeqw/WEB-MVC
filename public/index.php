<?php
session_start();

define('BASEURL', 'http://mvc.cihuy/');

require_once '../config/database.php';
require_once '../core/Controller.php';
require_once '../core/Router.php';

$router = new Router();
?>
