<?php
session_start();
require 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$id = $_POST['id'];

$result = get_user_on_email($email);

if (!empty($result)) {
    if ($id !== $result['id']) {
        set_type_messege('danger', "данный email {$email} уже занят другим пользователем");
        go_to_page("security.php?id=$id");
        exit;
    }
}
edit_credentials($email, $password, $id);

set_type_messege('success', "профиль {$email} успешно обновлен");
go_to_page("page_profile.php?id=$id");
