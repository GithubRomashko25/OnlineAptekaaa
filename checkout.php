<?php
$servername = "sql109.infinityfree.com";
$username = "if0_35518745";
$password = "ChIxQisruy7";
$dbname = "if0_35518745_durkshop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем данные о заказе из тела запроса
$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$items = $data['items'];

// Создаем новый заказ
$sql = "INSERT INTO `order` (user_name, total_price, status) VALUES ('$user_id', 0, 'In progress')";
$conn->query($sql);

// Получаем ID последнего добавленного заказа
$order_id = $conn->insert_id;

// Добавляем предметы в заказ
foreach ($items as $item_id) {
    // Получаем информацию о предмете
    $sql = "SELECT price FROM object WHERE id = $item_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $price = $row['price'];

    // Добавляем предмет в заказ
    $sql = "INSERT INTO order_item (order_id, object_name) VALUES ($order_id, '$item_id')";
    $conn->query($sql);

    // Обновляем общую стоимость заказа
    $sql = "UPDATE `order` SET total_price = total_price + $price WHERE id = $order_id";
    $conn->query($sql);

    $sql = "SELECT total_price FROM `order` WHERE id = $order_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $total_price = $row['total_price'];
}

// Закрываем соединение
$conn->close();

?>