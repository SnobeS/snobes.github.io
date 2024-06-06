<?php
session_start();
require_once("../db_config.php");
include("header.php");

if (isset($_SESSION['username'])) {
    header("Location: korvaus.php");
    exit();
}
// tarkistaa onko käyttäjänimi ja salasana oikein
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // valitsee databasesta täsmäävän käyttäjän tiedot (salasana ja käyttäjänimi)
    $stmt = $db_connection->prepare("SELECT * FROM users WHERE username = :username AND password = MD5(:password)");
    $stmt->execute(['username' => $username, 'password' => $password]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['username'] = $username;
        header("Location: korvaus.php");
        exit();
    } else {
        $loginError = "Virheellinen käyttäjänimi tai salasana!";
    }
}
?>

<!-- nappi pääsivulle -->
<form action="index.php" class="m-3">
    <input type="submit" class="btn btn-primary" value="Laskuri">
</form>

<!-- formi johon syötetään kirjautumis tiedot -->
<div class="container w-25 p-1 mt-5">
    <h1 class="text-center text-white">Kirjaudu</h1>
    <?php if (isset($loginError)): ?>
        <p class="text-danger text-center"><?php echo $loginError; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <div class="mb-1 text-white">
            <label for="username" class="form-label">Käyttäjänimi: </label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-1 text-white">
            <label for="password" class="form-label">Salasana:</label>
            <input type="password" id="password" name="password" class="form-control mb-3" required>
        </div>
        <input type="submit" value="Kirjaudu" class="btn btn-primary">
    </form>
</div>

<?php
include("footer.php");
?>
