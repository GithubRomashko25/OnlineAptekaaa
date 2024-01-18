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
    $address = $_POST['address'];
    $bitcoin = $_POST['bitcoin'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'Customer'; // Default role for registration

    $sql = "INSERT INTO user (login, password, role, address, bitcoin_wallet) 
            VALUES ('$login', '$password', '$role', '$address', '$bitcoin')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful";
        setcookie('user_id', $conn->insert_id, time() + (86400 * 30), '/');
        setcookie('role', 'Customer', time() + (86400 * 30), '/');
        setcookie('username', $username, time() + (86400 * 30), '/'); // Новая строка

        header("Location: catalog.html"); // Перенаправление на страницу каталога
        exit();
    } else {
        echo "Error during registration: " . $conn->error;
    }


}

$conn->close();
?>