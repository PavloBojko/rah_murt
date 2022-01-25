<?php
session_start();
require 'functions.php';
$id = $_POST['id'];
$email = $_POST['email'];

upload_avatar($_FILES['avatar']['tmp_name'], $_FILES['avatar']['name'], $id);
set_type_messege('success', "профиль {$email} успешно обновлен");
go_to_page("page_profile.php?id=$id");
