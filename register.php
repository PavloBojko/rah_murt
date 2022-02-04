<?php
session_start();
require 'functions.php';
$db = require 'database/start.php';
if (isset($_POST['reg'])) {
    $data = [
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ];

    $result = $db->get_table_if_no_data('users', ['email' => $_POST['email']]);
    // var_dump($result);
    if (!empty($result)) {

        set_type_messege('danger', 'Этот эл. адрес уже занят другим пользователем.');

        go_to_page('page_register.php');
        exit;
    }
    $db->add_table('users', $data);

    set_type_messege('success', 'Регистрация успешна');

    go_to_page('page_login.php');
}
