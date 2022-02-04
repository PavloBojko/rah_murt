<?php
session_start();
require 'functions.php';
$db = require 'database/start.php';


$email = $_POST['email'];
$password = $_POST['password'];

$data = [
    'email' => $_POST['email'],
    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
];
$data_gen_info = [
    'name' => $_POST['username'],
    'position' => $_POST['position'],
    'tel' => $_POST['tel'],
    'adres' => $_POST['adres']
];
$data_status = [
    'status' => $_POST['status']
];

$data_social_links = [
    'user_id' => $id,
    'telegram' => $_POST['telegram'],
    'instagram' => $_POST['instagram'],
    'vc' => $_POST['vk']
];

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

//добавляем пользоватеся и сразу же получаем ID
$id = $db->add_in_table_return_id('users', $data);

//обновляем общую инф.
$db->update_table('users', $data_gen_info, $id);

//обновляем статус
$db->update_table('users', $data_status, $id);



upload_avatar($_FILES['avatar']['tmp_name'], $_FILES['avatar']['name'], $id);

// add_social_links($telegram, $instagram, $vc, $id);
$data_social_links = [
    'user_id' => $id,
    'telegram' => $_POST['telegram'],
    'instagram' => $_POST['instagram'],
    'vc' => $_POST['vk']
];

//вставляем в таблицу social_links инф. о Пользователю
$db->add_table('social_links', $data_social_links);

set_type_messege('success', "Пользователь {$email} успешно добавлен");
go_to_page('users.php');
