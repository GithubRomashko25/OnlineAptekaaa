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

// Получаем данные из запроса
$data = json_decode(file_get_contents("php://input"), true);

// Проверяем, что данные получены корректно
if (isset($data['order_id']) && isset($data['new_status'])) {
    $order_id = $data['order_id'];
    $new_status = $data['new_status'];

    // Обновляем статус заказа
    $sql = "UPDATE `order` SET status = '$new_status' WHERE id = $order_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Order status updated successfully"]);
    } else {
        echo json_encode(["error" => "Error updating order status: " . $conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid data"]);
}

$conn->close();
?>
