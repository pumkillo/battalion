<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));
AuthMiddleware::check();

require_once(Loader::load('router'));
require_once(Loader::load('query'));
require_once(Loader::load('messages'));
if (Query::table('staff')->delete("id LIKE '".$_GET['id']."'")):
    Router::redirect('main');
else: 
    Messages::renderError('Ошибка увольнения');
endif;
