<?php
include("header.php");
require_once('../db_config.php');
$korvausID = $_POST['korvausID'];
$query = "SELECT * FROM matkakululaskuri WHERE korvausID = :korvausID LIMIT 1";
$result = $db_connection->prepare($query);
$result->execute(['korvausID' => $korvausID]);
$result = $result->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Muokkaa Luokkaa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container text-white mt-5">
        <form method="POST" action="update.php">
            <div class="form-group row">
                <div class="col-sm-10">
                    <input type="hidden" class="form-control" id="korvausID" name="korvausID" value="<?php echo $result['korvausID'] ?>">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="vuosiLuku" class="col-sm-2 col-form-label">Vuosi Luku</label>
                <div class="col-sm-10">
                    <input type="number" min="2000" max="2024" class="form-control" id="vuosiLuku" name="vuosiLuku" value="<?php echo $result['vuosiLuku'] ?>">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <label for="kmKorvaus" class="col-sm-2 col-form-label">Kilometrikorvaus</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="kmKorvaus" name="kmKorvaus" step="0.01" placeholder="0.00" value="0.00">
                </div>
            </div>
            <br>
            <button type="submit" name="updateRecord" class="btn btn-success">Päivitä</button>
    </div>
</form>
</body>
</html>
<?php include("footer.php") ?>