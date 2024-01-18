<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "sql109.infinityfree.com";
$username = "if0_35518745";
$password = "ChIxQisruy7";
$dbname = "if0_35518745_durkshop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получаем заказы для страницы доставки
$sql = "SELECT order.id as order_id, object.name as item_name, object.price, order.status FROM `order`
        JOIN order_item ON order.id = order_item.order_id
        JOIN object ON order_item.object_name = object.id
        WHERE order.status = 'Created' OR order.status = 'In process'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $orders = array();
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    echo json_encode($orders);
} else {
    echo json_encode([]);
}

$conn->close();
?>
