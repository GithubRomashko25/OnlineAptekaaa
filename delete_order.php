<?php
$servername = "sql109.infinityfree.com";
$username = "if0_35518745";
$password = "ChIxQisruy7";
$dbname = "if0_35518745_durkshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$order_id = $data['order_id'];

// Удаление заказа
$sql = "DELETE FROM `order` WHERE id = $order_id";
$conn->query($sql);

// Удаление связанных записей в order_item
$sql = "DELETE FROM order_item WHERE order_id = $order_id";
$conn->query($sql);

$conn->close();
?>
