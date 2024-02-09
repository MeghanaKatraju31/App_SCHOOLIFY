<?php
ob_start();
$db = mysqli_connect('localhost', 'root', '', 'uta_student');
if (!$db) {
    die('Could not connect to the database: ' . mysqli_connect_error());
}

if(!empty($_GET['logout']) && $_GET['logout'] == 1) {
	session_unset();
}
define('UPLOAD_DIR', __DIR__.'/src/');