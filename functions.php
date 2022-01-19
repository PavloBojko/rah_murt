<?php
//получаем пользователя по email
function get_user_on_email(string $email = null)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "SELECT * FROM `users` WHERE `email` LIKE :email";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}
// регестрируем пользователя
function add_user(string $email, string $password)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "INSERT INTO `users` (`email`, `password`) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);
}
//формируем сообщение
function set_type_messege(string $type = null, string $messege = null)
{
    $_SESSION[$type] = $messege;
}
//переход на страницу
function go_to_page(string $page = null)
{
    header("location: /{$page}");
}
//вывод сообщения уже на страницу
function display_get_messege(string $name = null)
{
    if (isset($_SESSION[$name])) {

        echo "<div class='alert alert-$name text-dark' role='alert'>
        <strong>Уведомление!</strong> $_SESSION[$name]</div>";
        unset($_SESSION[$name]);
    }
}
//авторизация
function auth(string $email, string $password)
{

    $result = get_user_on_email($email);
    if (empty($result)) {
        set_type_messege('danger', 'Пользователь не найден');
        return false;
    }

    $hash = $result["password"];
    
    if (!password_verify($password, $hash)) {
        set_type_messege('danger', 'Неверный пароль');
        return false;
    }else {
        $_SESSION['user']=$result["email"];
        set_type_messege('success', " Профиль <b>{$result['email']}</b> успешно обновлен");
        return true;
    }
}
