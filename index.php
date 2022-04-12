<?php
require_once(__DIR__ . '/App/Loader.php');
require_once(Loader::load('query'));
require_once(Loader::load('constants'));
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <?php
    require_once(Loader::load('views') . 'patterns/head.php');
    ?>
    <title>Главная</title>
</head>


<body>
    <div class="container">
        <?php
        require_once(Loader::load('views') . 'patterns/header.php');
        foreach (Query::table('staff')->all() as $item) : ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $item['name'] ?? 'У этого товара нет наименования' ?></h5>
                    <p class="card-text"><?= $item['description'] ?? 'Нет описания' ?></p>
                    <p class="card-text"><?= $item['price'] . '&#x20bd;' ?? 'Цена не указана' ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>