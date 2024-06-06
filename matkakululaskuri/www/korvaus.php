<?php
// aloittaa istunnon
session_start();
// tarkistaa onko käyttäjä kirjautunut
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once("../db_config.php");
include("header.php");
$query2 = "SELECT * FROM matkakululaskuri";
$results2 = $db_connection->query($query2);

// tarkistaa onko formi lähtetty
if(isset($_POST['korvausForm'])) {
    $vuosiLuku = filter_var($_POST['vuosiLuku'], FILTER_SANITIZE_NUMBER_INT);
    $kmKorvaus = filter_var($_POST['kmKorvaus'], FILTER_VALIDATE_FLOAT);
    
    // kysely lisää vuosiLuvun ja kmKorvauksen databaseen
    $query = "INSERT INTO matkakululaskuri (vuosiLuku, kmKorvaus)
          VALUES (:vuosiLuku, :kmKorvaus)";
              
    $result = $db_connection->prepare($query);
    $result->execute([
        'vuosiLuku' => $vuosiLuku,
        'kmKorvaus' => $kmKorvaus,
    ]);
    
    $rows = $result->rowCount();
    
    if ($rows == 1) {
        header('Location: korvaus.php');
        exit();
    } else {
        $error_message = "Korvauksen lisääminen epäonnistui";
    }
};

?>

<!-- nappi pääsivulle -->
<form action="index.php" class="m-3">
    <input type="submit" class="btn btn-primary" value="Laskuri">
</form>
<!-- nappi josta kirjaudutaan ulos -->
<form action="logOut.php" method="GET" class="m-3">
        <input type="submit" class="btn btn-danger" value="Kirjaudu Ulos" >
</form>
<!-- formi jossa syötetään kilometrikorvauksen tiedot -->
<div class="container w-25 mb-5">
    <br>
    <form method="POST" action=" ">
        <div class="mb-4">
            <label for="vuosiLuku" class="form-label text-white">Syötä vuosiluku kilometrikorvaukselle:</label>
            <input type="number" min="2000" max="2024" name="vuosiLuku" id="vuosiLuku" placeholder="Syötä vuosiluku.." class="form-control" required>
        </div>
        <div class="mb-2">
            <label for="kmKorvaus" class="form-label text-white">Syötä kilometrikorvauksen summa (0,00€/km)</label>
            <input type="number" id="kmKorvaus "name="kmKorvaus" step="0.01" value="0.00" placeholder="0.00" class="form-control" required>
        </div>
        <br>
        <div>
            <button class="btn btn-success" name="korvausForm">Tallenna</button>
        </div>
    </form>
</div>
<table class="table text-white container">
            <thead>
                <tr>
                    <th>Olemassa olevat korvaukset:</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results2 as $result2) {
                ?>
                <tr>
                    <td>
                      <?php echo "Vuosi: " . $result2['vuosiLuku'] ?>
                    </td>
                    <td>
                      <?php echo "Korvauksen määrä: " . $result2['kmKorvaus'] . "€/km"?>
                    </td>
                    <form action="edit.php" method="POST">
                      <td><button type="submit" class="btn btn-primary" name="korvausID" value="<?php echo $result2 ['korvausID'] ?>">Muokkaa Korvausta</button></a></td>
                    </form>
                    
                    <form action="delete.php" method="POST">
                      <td><button type="submit" class="btn btn-danger" name="korvausID" value="<?php echo $result2 ['korvausID'] ?>">Poista Korvaus</button></td>
                    </form> 
                  </tr>
                  <?php
                }
                ?>
            </tbody>
          </table>
</div>
<?php
include("footer.php");
?>