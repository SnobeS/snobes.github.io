<?php
require_once("../db_config.php");
include("header.php");

// hakee vuosiluvut ja kilometrikorvaukset databasesta
$query = "SELECT vuosiLuku, kmKorvaus FROM matkakululaskuri";
$results = $db_connection->query($query);

// tarkistaa onko lomake lähetetty ja kaikki tarvittavat kentät täytetty
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kmStart']) 
    && isset($_POST['kmEnd'])
    && isset($_POST['timeStart'])
    && isset($_POST['timeEnd'])
    && isset($_POST['year'])) {

    // hakee lomaketiedot ja muuttaa ne oikeaan muotoon
    $kmStart = intval($_POST['kmStart']);
    $kmEnd = intval($_POST['kmEnd']);
    $year = intval($_POST['year']);
    $aloitaAika = $_POST['timeStart'];
    $lopetaAika = $_POST['timeEnd'];

    // funktio joka muuttaa ajan minuuteiksi
    function muutaMin($timeString) {
        list($hours, $minutes) = explode(':', $timeString);
        return intval($hours) * 60 + intval($minutes);
    }

    // muuttaa alkamis- ja lopetusajat minuuteiksi
    $aloitaMin = muutaMin($aloitaAika);
    $lopetaMin = muutaMin($lopetaAika);

    // laskee matkan keston minuuteissa
    $kestoMin = $lopetaMin - $aloitaMin;
    if ($kestoMin < 0) {
        $kestoMin += 24 * 60; // korjaa yli vuorokauden menevät ajat
    }

    // muuntaa keston tunneiksi ja minuuteiksi
    $kestoTunnit = intval($kestoMin / 60);
    $loputMin = $kestoMin % 60;

    // laskee ajetut kilometrit
    $matka = $kmEnd - $kmStart;

    // hakee kilometrikorvauksen tietokannasta
    $query = "SELECT kmKorvaus FROM matkakululaskuri WHERE vuosiLuku = :year";
    $stmt = $db_connection->prepare($query);
    $stmt->execute(['year' => $year]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // asettaa kilometrikorvauksen määrän
    if ($result) {
        $kilometriKorvausMaara = $result['kmKorvaus'];
    } else {
        $kilometriKorvausMaara = 0.54; 
    }

    // päivärahan määrä
    $paivaRahaMax = 12;
    $paivaRahaMin = 4.5;
    if ($kestoTunnit > 4) {
        $paivaRaha = $paivaRahaMax;
    } else {
        $paivaRaha = $paivaRahaMin;
    }

    // laskee korvauksen
    $kilometriKorvaus = $matka * $kilometriKorvausMaara;
    $yhteensa = $kilometriKorvaus + $paivaRaha;
}
?>

<div>
    <form action="login.php" class="m-3">
        <button class="btn btn-primary m">Lisää kilometrikorvaus</button> <!-- nappi kilometrikorvaukse lisäämiseen -->
    </form>
</div>

<div>
    <br>
    <form class="container" id="textField" action="" method="POST">
        <!-- form tietojen syöttämiseen -->
        <div class="mb-4">
            <label for="kmStart" class="form-label text-white">Kilometrit matkan alussa:</label>
            <input type="number" name="kmStart" id="kmStart" placeholder="Syötä kilometrit matkan alussa.." class="form-control" required>
        </div>
        <div class="mb-4">
            <label for="kmEnd" class="form-label text-white">Kilometrit matkan lopussa:</label>
            <input type="number" name="kmEnd" id="kmEnd" placeholder="Syötä kilometrit matkan lopussa.." class="form-control" required>
        </div>
        <div class="mb-4">
            <label for="timeStart" class="form-label text-white">Matka alkoi (tunnit : minuutit):</label>
            <input type="time" name="timeStart" id="timeStart" placeholder="Syötä matkan alkuaika.." class="form-control" required>
        </div>
        <div class="mb-4">
            <label for="timeEnd" class="form-label text-white">Matka loppui (tunnit : minuutit):</label>
            <input type="time" name="timeEnd" id="timeEnd" placeholder="Syötä matkan lopetusaika.." class="form-control" required>
        </div>
        
        <div>
            <label for="year" class="form-label text-white">Kilometrikorvauksen perustevuosi:</label>
            <select name="year" id="year" class="form-control">
                <?php 
                    // tulostaa vuosiluvut
                    foreach ($results as $result) {
                        echo "<option value='{$result['vuosiLuku']}'>{$result['vuosiLuku']}</option>";
                    };
                ?>
            </select>
        </div>
        <br>
        <div class="text-center d-grid gap-2 col-3 mx-auto">
            <button class="btn btn-success btn-lg" name="textField">Laske</button> <!-- nappi laskemiseen -->
        </div>
    </form>
</div>

<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($yhteensa)): ?>
<div id="tulosDiv" class="container text-white p-3 mt-5 bg-success rounded-2">
    <h1>Matkakulukorvaus</h1>
    <h2>Kilometrikorvaus</h2>
    <!-- näyttää lasketun kilometrikorvauksen -->
    <p>Matkan kilometrit: <?php echo $matka; ?> km ja kilometrikorvaus <?php echo $kilometriKorvausMaara; ?> € = <?php echo $kilometriKorvaus; ?> €</p>
    <h2>Päiväraha</h2>
    <!-- näyttää lasketun päivärahan -->
    <p>Matkan kesto <?php echo $kestoTunnit; ?>:<?php echo ($loputMin < 10 ? '0' : '') . $loputMin; ?> tuntia. Päiväraha on <?php echo $paivaRaha; ?> €</p>
    <h2>Yhteensä</h2>
    <!-- näyttää kokonaiskorvauksen -->
    <p><?php echo $kilometriKorvaus; ?> € + <?php echo $paivaRaha; ?> € = <?php echo $yhteensa; ?> €</p>
</div>
<?php endif; ?>