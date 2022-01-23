<?php
session_start();
require 'functions.php';
echo '<pre>';
var_dump($_POST);
$name=$_POST['username'];
$position=$_POST['position'];
$tel=$_POST['tel'];
$adres=$_POST['adress'];
$id=$_POST['id'];


add_general_info($name, $position, $tel, $adres, $id);

set_type_messege('success', 'Профиль успешно обновлен');

go_to_page("page_profile.php?id=$id");