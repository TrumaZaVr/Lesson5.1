<?php
require __DIR__ . '/vendor/autoload.php';
$api = new \Yandex\Geo\Api();
if (!empty($_POST['address'])) {
    $api->setQuery($_POST['address']);
}
$api
    ->setLimit(100)// кол-во результатов
    ->setLang(\Yandex\Geo\Api::LANG_RU)// локаль ответа
    ->load();
$response = $api->getResponse();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>API yandex/geo</title>
    <meta charset="utf-8">
    <style>
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        table td, table th {
            border: 3px solid #c0ccb4;
            padding: 10px;
        }
        table th {
            background: #ddeed5;
        }
    </style>
</head>
<body>
<h2>API для работы с сервисом Яндекс.Геокодирование</h2>
<form method="POST">
    <input type="text" name="address" placeholder="Введите адрес">
    <input type="submit" name="search" value="Найти">
</form>
<?php if(!empty($_POST['address'])) { ?>
    <table>
        <tr>
            <th>По запросу <?php echo $response->getQuery(); ?> найдено адресов: <?php echo $response->getFoundCount(); ?></th>
            <th>Координаты</th>
        </tr>
        <?php
        $collection = $response->getList();
        foreach ($collection as $item) { ?>
            <tr>
                <td><?php echo $item->getAddress(); ?></td>
                <td><?php echo $item->getLatitude()." ".$item->getLongitude(); ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
</body>
</html>