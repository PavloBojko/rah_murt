<?php
require __DIR__.'/../rout/Rout.php';
$mod = require __DIR__.'./../model/model.php';

$rout = new Rout($mod);

$rout->add_rout('/users' , 'page_users.php');
// echo'<pre>';
// var_dump($rout->spisok_url);
$rout->enable();

