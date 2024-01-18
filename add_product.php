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

// Получаем данные из тела запроса
$data = json_decode(file_get_contents("php://input"));

// Проверяем наличие данных
if (isset($data->name) && isset($data->price)) {
    $productName = $data->name;
    $productPrice = $data->price;

    // Устанавливаем статус "Available" по умолчанию
    $productStatus = "Available";

    // Добавляем новый продукт в базу данных
    $sql = "INSERT INTO object (name, price, status) VALUES ('$productName', $productPrice, '$productStatus')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Product added successfully'));
    } else {
        echo json_encode(array('error' => 'Error adding product: ' . $conn->error));
    }
} else {
    echo json_encode(array('error' => 'Product data not provided'));
}

$conn->close();

?>
