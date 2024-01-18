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

$sql = "SELECT * FROM object";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price']
        );
    }
    echo json_encode($products);
} else {
    echo json_encode([]);
}

$conn->close();

?>
