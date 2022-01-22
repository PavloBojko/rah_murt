<?php
session_start();
require 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$position = $_POST['position'];
$tel = $_POST['tel'];
$adres = $_POST['adres'];
$status = $_POST['status'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];
$vc = $_POST['vk'];

if (empty($email) || empty($password)) {
    set_type_messege('danger', 'Поле email и password  должны бить обязательно заполнеными');
    go_to_page('create_user.php');
    exit;
}

$result = get_user_on_email($email);
if (!empty($result)) {
    set_type_messege('danger', "Этот {$email} уже занят другим пользователем");
    go_to_page('create_user.php');
    exit;
}
$id = add_User_return_id($email, $password);

add_general_info($username, $position, $tel, $adres, $id);

set_status($status, $id);

upload_avatar($_FILES['avatar']['tmp_name'], $_FILES['avatar']['name'], $id);

add_social_links($telegram, $instagram, $vc, $id);
set_type_messege('success', "Пользователь {$email} успешно добавлен");
go_to_page('users.php');
