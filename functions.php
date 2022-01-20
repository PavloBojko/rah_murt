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
        set_type_messege('success', " Ппользователь <b>{$result['email']}</b> успешно авторизирован");
        return true;
    }
}
//аторизирован ли пользователь
function or_an_auth_user()
{
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        return true;
    }
    return false;
}
//админ ли пользователь
function user_is_admin(string $email)
{
   $result = get_user_on_email($email);
//    var_dump($result);
   if ($result['role']==='admin') {
       return true;
   }
   return false;
}
//получить всех пользователей
function get_all_users()
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "SELECT * FROM `users`";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;

}