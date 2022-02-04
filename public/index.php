<?php
// echo '<pre>';
// var_dump($_SERVER['REDIRECT_URL']);
$route = $_SERVER['REDIRECT_URL'];

$routes = [
    null=>'users.php',
    '/login'=>'page_login.php',
    '/register'=>'page_register.php'
];

// if ($_SERVER['REDIRECT_URL']==) {
//     # code...
// }
if (array_key_exists($route, $routes)) {
    require __DIR__ .'./../'. $routes[$route];
    echo "Массив содержит элемент <h1>{$routes[$route]}</h1>";
}else{
    echo '<h1>Eroor 404</h1>';
}