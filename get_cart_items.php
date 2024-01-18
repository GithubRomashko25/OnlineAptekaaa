<?php
$servername = "sql109.infinityfree.com";
$username = "if0_35518745";
$password = "ChIxQisruy7";
$dbname = "if0_35518745_durkshop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to the database successfully!";
}

// Получаем данные о пользователе из кук
$user_id = isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : null;

if ($user_id) {
    // Получаем данные о предметах в корзине пользователя
    $sql = "SELECT object_id FROM cart WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result) {
        echo "Query executed successfully!";
        $cartItems = [];

        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row['object_id'];
        }

        // Отправляем JSON-ответ с предметами в корзине
        header('Content-Type: application/json');
        echo json_encode($cartItems);
    } else {
        // Ошибка запроса к базе данных
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $conn->error]);
    }
} else {
    // Ошибка: пользователь не аутентифицирован
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
}

// Закрываем соединение
$conn->close();
?>
