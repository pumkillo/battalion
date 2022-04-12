<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));
require_once(Loader::load('router'));
require_once(Loader::load('constants'));
require_once(Loader::load('query'));
require_once(Loader::load('session'));
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <?php
    require_once(Loader::load('views') . 'patterns/head.php');
    ?>
    <title>Авторизация</title>
</head>


<body>
    <div class="container">
        <?php
        if (!empty($_POST)) {
            $password = md5($_POST['password']);
            $res = Query::table('admins')->where("login LIKE '" . $_POST['login'] . "' AND password LIKE '$password'");

            if (isset($res[0]) && $res[0]['login'] === $_POST['login'] && $res[0]['password'] === $password) {
                Session::set('id', $res[0]['id']);
                Router::redirect('main');
            } else {
                $message = "Введены некорректные данные!";
            }
        }
        require_once(Loader::load('views') . 'patterns/header.php');
        if (!AuthMiddleware::is()) :
        ?>
            <div class="container">
                <form method="post" class="container" style="max-width: 500px;">
                    <div class="mb-3">
                        <input type="text" name="login" placeholder="Введите Ваш логин" class="form-control">
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" placeholder="Введите Ваш пароль" class="form-control">
                    </div>

                    <p class="errors text-danger"><?= $message ?? '' ?></p>
                    <input type="submit" value="Войти" class="btn btn-primary">
                </form>
            <?php else : ?>
                <p>Вы уже вошли в систему.</p>
            <?php endif; ?>
            </div>
    </div>

</body>