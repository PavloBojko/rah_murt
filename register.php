<?php
session_start();
require 'functions.php';
// var_dump($_POST);
if (isset($_POST['reg'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = get_user_on_email($email);

    if (!empty($result)) {

        set_type_messege('danger', 'Этот эл. адрес уже занят другим пользователем.');

        go_to_page('page_register.php');
        exit;
    }
    add_user($email, $password);

    set_type_messege('success', 'Регистрация успешна');

    go_to_page('page_login.php');
}
