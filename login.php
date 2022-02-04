<?php
session_start();
require 'functions.php';
$db = require 'database/start.php';


if (isset($_POST['auth'])) {
    $data = [
        $email = $_POST['email'],
        $password = $_POST['password']
    ];

    if (auth($email, $password)) {
        go_to_page('users.php');
    } else {
        go_to_page('page_login.php');
    }
}
