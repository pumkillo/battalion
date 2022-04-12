<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('middlewares'));
require_once(Middlewares::getClass('auth'));
AuthMiddleware::check();

require_once(Loader::load('constants'));
require_once(Loader::load('router'));
require_once(Loader::load('query'));
require_once(Loader::load('session'));
require_once(Loader::load('validators'));
require_once(Loader::load('messages'));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Добавление роты</title>
    <?php
    require_once(Loader::load('views') . 'patterns/head.php');
    ?>
</head>

<body>
    <div class="container">
        <?php
        require_once(Loader::load('views') . 'patterns/header.php');

        $errors = [];

        if (!empty($_POST)) {
            $validator = new Validators($_POST, [
                'name' => ['unique:companies,name', 'required', 'min_max:,2,40', 'russian'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
            } else {
                if (Query::table('companies')->insert([
                    'name' => $_POST['name'],
                ])) {
                    Router::redirect('main');
                }
                $message = 'Ошибка добавления роты';
            }
        }

        ?>
        <form method="post" class="container">
            <div class="mb-3">
                <label for="name" class="form-label">Название роты</label>
                <input id="name" type="text" name="name" placeholder="Первая рота" class="form-control">
                <?php Messages::renderErrors($errors, 'name'); ?>
            </div>
            <input type="submit" value="Добавить" class="btn btn-primary">
        </form>
    </div>
    <?php require_once(Loader::load('views') . 'patterns/footer.php'); ?>
</body>

</html>