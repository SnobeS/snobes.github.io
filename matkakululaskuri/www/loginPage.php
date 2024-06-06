<?php 

include("login.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {

    require("../db_config.php");

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db_connection->prepare("SELECT * FROM users WHERE username = :username AND password = MD5(:password)");
    $stmt->execute(['username' => $username, 'password' => $password]);

    if($stmt->rowCount() > 0) {
        session_start();
        $_SESSION['username'] = $username;
            header("Location: korvaus.php");
            exit();
        } else {
            echo "Virheellinen käyttäjänimi tai salasana!";
        }
        $db_connection = null;
}


