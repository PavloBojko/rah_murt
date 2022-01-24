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
    } else {
        $_SESSION['user'] = $result["email"];
        if ($result['role'] === 'admin') {
            $_SESSION['admin'] = true;
        } else {
            $_SESSION['admin'] = false;
        }
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
// function user_is_admin(string $email)
// {
//     $result = get_user_on_email($email);
//     //    var_dump($result);
//     if ($result['role'] === 'admin') {
//         $_SESSION['admin'] = true;
//         return true;
//     }
//     return false;
// }
//админ ли пользователь через сесию
function user_is_admin_in_Sesion()
{
    if (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
        return true;
    } else {
        return false;
    }
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
//функция которая добавляет пользователя () и сразу же возвращает его id
function add_User_return_id(string $email, string $password)
{
    add_user($email, $password);
    $result = get_user_on_email($email);
    return $result['id'];
}
//добавляем общую информацию 
function add_general_info($name, $position, $tel, $adres, $id)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "UPDATE `users` SET `name` = :name, `position` = :position, `tel` = :tel, `adres` = :adres WHERE `users`.`id` = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['name' => $name, 'position' => $position, 'tel' => $tel, 'adres' => $adres, 'id' => $id]);
}
//Устанавливаем статус
function set_status($status, $id)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "UPDATE `users` SET `status` = :status WHERE `users`.`id` = :id;";
    $statement = $pdo->prepare($sql);
    $statement->execute(['status' => $status, 'id' => $id]);
}
//Загружаем аватар
function upload_avatar($tmp, $name, $id)
{
    $typ = pathinfo($name, PATHINFO_EXTENSION);
    $filName = uniqid();
    $way = "img/avatar/{$filName}.$typ";
    move_uploaded_file($tmp, $way);

    $pdo = new PDO("mysql:host=localhost;dbname=rahmur", "root", "");
    $sql = "UPDATE `users` SET `avatar` = :text WHERE `users`.`id` = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['text' => $way, 'id' => $id]);
}
//добавляем ссилки на соцсети
function add_social_links($telegram, $instagram, $vc, $id)
{
    $pdo = new PDO("mysql:host=localhost;dbname=rahmur", "root", "");
    $sql = "INSERT INTO `social_links` (`user_id`, `telegram`, `instagram`, `vc`) VALUES (:id, :telegram, :telegram, :vc)";
    $statement = $pdo->prepare($sql);
    $statement->execute(['telegram' => $telegram, 'instagram' => $instagram, 'vc' => $vc, 'id' => $id]);
}
//получаем пользователя по id
function get_user_on_id(string $id = null)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "SELECT * FROM `users` WHERE `id` = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}
// 
function edit_credentials($email, $password, $id)
{
    $pdo = new PDO('mysql:hosh=localhost;dbname=rahmur', 'root', '');
    $sql = "UPDATE `users` SET `email` = :email, `password` = :password WHERE `users`.`id` = :id";
    $statement = $pdo->prepare($sql);
    
   $statement->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'id' => $id]);
}
