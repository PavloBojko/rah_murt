<?php
session_start();
require 'functions.php';

$status = $_POST['status'];
$id = $_POST['id'];
$email = $_POST['email'];

update_status($status, $id);
set_type_messege('success', "профиль {$email} успешно обновлен");
go_to_page("page_profile.php?id=$id");
