<?php
session_start();
require 'functions.php';
$id = $_GET['id'];

if (!or_an_auth_user()) {
    go_to_page('page_login.php');
    exit;
}
$result = get_user_on_id($id);

if (!user_is_admin_in_Sesion()) {
    if ($_SESSION['user'] != $result['email']) {
        set_type_messege('danger', 'Можно удалить только свой профиль');
        go_to_page('users.php');
        exit;
    }
}

del_user($id);

set_type_messege('success', "профиль {$result['email']} успешно удален");

if ($_SESSION['user']!=$result['email']) {
    go_to_page("users.php");
    exit;
}
session_destroy();
go_to_page("page_register.php");
