<?php
$db = require 'database/start.php';
$result = $db->get_table_if_no_data('users');
echo '<pre>';
var_dump($result);