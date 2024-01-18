<?php
$servername = "sql109.infinityfree.com";
$username = "if0_35518745";
$password = "ChIxQisruy7";
$dbname = "if0_35518745_durkshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $enteredPassword = $_POST['password'];

    $sql = "SELECT * FROM user WHERE login = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHash = $row['password'];

        // Добавим эти строки
        $userId = $row['id'];
        $userRole = $row['role'];
        $username = $row['nickname'];

        if (password_verify($enteredPassword, $storedHash)) {
            // Вход успешен
            setcookie('user_id', $userId, time() + (86400 * 30), '/'); // Сохраняем user_id
            setcookie('login', $login, time() + (86400 * 30), '/'); // Сохраняем login
            setcookie('role', $userRole, time() + (86400 * 30), '/');
            setcookie('username', $username, time() + (86400 * 30), '/');

            header("Location: catalog.html"); // Перенаправление на страницу каталога
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";

        // Добавим вывод для отладки
        echo "<br>";
        echo "Login: " . $login;
        echo "<br>";
        echo "Entered Password: " . $enteredPassword;
        // Добавьте код для несуществующего пользователя
    }
}


$conn->close();
?>
