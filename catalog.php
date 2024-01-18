<?php
$servername = "sql109.infinityfree.com";
$username = "if0_35518745";
$password = "ChIxQisruy7";
$dbname = "if0_35518745_durkshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM object";
$result = $conn->query($sql);

$items = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price']
        );
    }
}

$conn->close();

// Возвращаем данные в виде JSON
echo json_encode($items);
?>
