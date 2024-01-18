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
if (isset($data->id)) {
    $productId = $data->id;

    // Удаляем продукт из базы данных
    $sql = "DELETE FROM object WHERE id = $productId";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Product deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting product: ' . $conn->error));
    }
} else {
    echo json_encode(array('error' => 'Product ID not provided'));
}

$conn->close();

?>
