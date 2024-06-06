<?php

require_once("../db_config.php");

if(isset($_POST['timeStart']) 
&& isset($_POST['timeEnd'])
&& isset($_POST['kmStart'])
&& isset ($_POST['kmEnd'])) {

    $kmStart = intval($_POST['kmStart']);
    $kmEnd = intval($_POST['kmEnd']);

    $aloitaAika = $_POST['timeStart'];
        $lopetaAika = $_POST['timeEnd'];

        function muutaMin($timeString) {
            list($hours, $minutes) = 
        explode(':', $timeString);
            $hours = intval($hours);
            $minutes = intval($minutes);
            return $hours * 60 + $minutes;
        }

        $aloitaMin = muutaMin($aloitaAika);
        $lopetaMin = muutaMin($lopetaAika);

        $kestoMin = $lopetaMin - $aloitaMin;

        if ($kestoMin < 0) {
            $kestoMin += 24 * 60;
        }

        $kestoTunnit = intval($kestoMin / 60);
        $loputMin = $kestoMin % 60;

        $matka = $kmEnd - $kmStart;

        $kilometriKorvausMaara = 0.54;

        $paivaRahaMax = 12;
        $paivaRahaMin = 4.5;

        if ($kestoTunnit > 4) {
            $paivaRaha = $paivaRahaMax;
        } else {
            $paivaRaha = $paivaRahaMin;
        }

        $kilometriKorvaus = $matka * $kilometriKorvausMaara;
        $yhteensa = $kilometriKorvaus + $paivaRaha;

        $tulosMaara = 

        echo "<h1>Kilometrikorvaus</h1><br> Matkan kilometrit: " . $matka . " kilometrikorvaus " . $kilometriKorvausMaara . "=" . $tulosMaara;
        
}
