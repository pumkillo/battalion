<?php
require_once(__DIR__ . "/../../App/Loader.php");
require_once(Loader::load('router'));
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));

?>
<div class="header d-flex justify-content-between">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <a class="nav-link" href="<?= ROOT ?><?= Router::get('main') ?>"><img src="<?= ASSETS ?>static/images/logo.svg" alt="logo"></a>
    <ul class="nav justify-content-end">
        <?php
        if (!AuthMiddleware::is()) :
        ?>
            <li class="nav-item"><a class="nav-link" href="<?= ROOT ?><?= Router::get('login') ?>">Войти</a></li>
        <?php else : ?>
            <div class="btn-group">
                <button type="button" class="btn btn-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Добавить
                </button>
                <ul class="dropdown-menu">
                    <li class="nav-item"><a class="dropdown-item nav-link" href="<?= ROOT ?><?= Router::get('add_employee') ?>">Нового сотрудника</a></li>
                    <li class="nav-item"><a class="dropdown-item nav-link" href="<?= ROOT ?><?= Router::get('add_company') ?>">Новую роту</a></li>
                    <li class="nav-item"><a class="dropdown-item nav-link" href="<?= ROOT ?><?= Router::get('add_platoon') ?>">Новый взвод</a></li>
                    <li class="nav-item"><a class="dropdown-item nav-link" href="<?= ROOT ?><?= Router::get('add_division') ?>">Новое отделение</a></li>
                </ul>
            </div>
            <li class="nav-item"><a class="nav-link text-danger" href="<?= ROOT ?><?= Router::get('logout') ?>">Выйти</a></li>
        <?php endif; ?>
    </ul>
</div>