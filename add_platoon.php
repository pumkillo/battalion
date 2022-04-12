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
    <title>Добавление взвода</title>
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
                'name' => ['unique:platoons,name', 'required', 'min_max:,2,20', 'russian'],
            ]);

            if (!isset($_POST['company_id'])) {
                $message = 'Вы не можете добавить взвод';
            } else {
                if ($validator->fails()) {
                    $errors = $validator->errors();
                } else {
                    if (Query::table('platoons')->insert([
                        'name' => $_POST['name'],
                        'company_id' => $_POST['company_id'],
                    ])) {
                        Router::redirect('main');
                    }
                    $message = 'Ошибка добавления взвода';
                }
            }
        }

        ?>
        <form method="post" class="container">
            <div class="mb-3">
                <label for="company_id" class="form-label">Рота</label>
                <?php
                $companies = Query::table('companies')->all();
                if (count($companies) !== 0) :
                ?>
                    <select name="company_id" id="company_id" class="form-select">
                        <?php foreach ($companies as $company) : ?>
                            <option value="<?= $company['id'] ?>"><?= $company['name'] ?></option>
                        <?php endforeach; ?>
                    <?php else :
                    Messages::renderError('Нет ни одной роты в базе данных');
                endif; ?>
                    </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Название взвода</label>
                <input id="name" type="text" name="name" placeholder="Взвод №4" class="form-control" value="<?= $_POST['name'] ?? '' ?>">
                <?php Messages::renderErrors($errors, 'name'); ?>
            </div>
            <?php
            if (isset($message)) {
                Messages::renderError($message);
            }
            ?>
            <input type="submit" value="Добавить" class="btn btn-primary">
        </form>
    </div>
    <?php require_once(Loader::load('views') . 'patterns/footer.php'); ?>
</body>

</html>