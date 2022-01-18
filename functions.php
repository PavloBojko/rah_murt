<?php

function get_user_on_email(string $email = null)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "SELECT * FROM `users` WHERE `email` LIKE :email";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function add_user(string $email, string $password)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "INSERT INTO `users` (`email`, `password`) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
}

function set_type_messege(string $type = null, string $messege = null)
{
    $_SESSION[$type] = $messege;
}

function go_to_page(string $page = null)
{
    header("location: /{$page}");
}
function display_get_messege(string $name = null)
{
    if (isset($_SESSION[$name])) {

        echo "<div class='alert alert-$name text-dark' role='alert'>
        <strong>Уведомление!</strong> $_SESSION[$name]</div>";
        unset($_SESSION[$name]);
    }
}
