<?php

require_once('../db_config.php');

if (isset($_POST['updateRecord'])) {

    $korvausID = filter_var($_POST['korvausID'], FILTER_SANITIZE_NUMBER_INT);
    $vuosiLuku = filter_var($_POST['vuosiLuku'], FILTER_UNSAFE_RAW);
    $kmKorvaus = filter_var($_POST['kmKorvaus'], FILTER_VALIDATE_FLOAT);
    $query = "UPDATE matkakululaskuri SET vuosiLuku = :vuosiLuku, kmKorvaus = :kmKorvaus WHERE korvausID = :korvausID LIMIT 1";

    $result = $db_connection->prepare($query);
    $result->execute([
        ':korvausID' => $korvausID,
        ':vuosiLuku' => $vuosiLuku,
        ':kmKorvaus' => $kmKorvaus,
    ]);
    $rows = $result->rowCount();
    if ($rows == 1) {
        header('Location: korvaus.php');
    } else {
        $error_message = "Korvauksen muokkaaminen epäonnistui!";
    }
}

?>