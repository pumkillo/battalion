<?php
require_once(__DIR__ . "/../../App/Loader.php");
require_once(Loader::load('router'));
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));

?>
<div class="header d-flex justify-content-between">
    <a class="nav-link" href="<?= ROOT ?><?= Router::get('main') ?>">Главная</a>
    <ul class="nav justify-content-end">
        <?php
        if (!AuthMiddleware::is()) :
        ?>
            <li class="nav-item"><a class="nav-link" href="<?= ROOT ?><?= Router::get('login') ?>">Войти</a></li>
        <?php else : ?>
            <li class="nav-item"><a class="nav-link text-danger" href="<?= ROOT ?><?= Router::get('logout') ?>">Выйти</a></li>
        <?php endif; ?>
    </ul>
</div>