<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Loader::load('session'));
require_once(Middlewares::getClass('auth'));
AuthMiddleware::check();

require_once(Loader::load('constants'));
require_once(Loader::load('router'));
require_once(Loader::load('session'));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Выход</title>
    <?php
    require_once(Loader::load('views') . 'patterns/head.php');
    ?>
</head>

<body>
    <div class="container">
        <?php
        require_once(Loader::load('views') . 'patterns/header.php');
        if (!AuthMiddleware::is()) :
        ?>
            <p>Чтобы выйти, Вы должны быть авторизированы.</p>
        <?php else :
            Session::unset('id');
            Router::redirect('main');
        endif;
        ?>
    </div>
</body>

</html>