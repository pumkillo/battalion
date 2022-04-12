<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));
AuthMiddleware::check();

require_once(Loader::load('session'));
require_once(Loader::load('router'));
Session::unset('id');
Router::redirect('main');
