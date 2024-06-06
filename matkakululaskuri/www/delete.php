<?php

require_once("../db_config.php");

if(!isset($_POST['korvausID'])) {
    header('Location: korvaus.php');
    die();
} else {
    $id = filter_var($_POST['korvausID'], FILTER_SANITIZE_NUMBER_INT);
    if(!$id) {
        header('Location: delete.php');
        die();
    } else {
        $query = "DELETE  FROM matkakululaskuri WHERE korvausID = :korvausID LIMIT 1";
        $result = $db_connection->prepare($query);
        $result->execute(['korvausID' => $id]);
        $rowsdeleted = $result->rowCount();
        if ($rowsdeleted == 1) {
            header("Location: korvaus.php");
        } else {
            $error_message = "Record was not deleted.";
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Poista Luokka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($error_message)) {
            ?>
            <div class="alert alert-danger">
                <strong>Error!</strong>
                <?php echo $error_message; ?> Go back to <a href="korvaus.php" class="alert-link">List of classes</a>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>