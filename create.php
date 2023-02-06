<?php
require_once 'webservice/includes/db.php';
/** @var mysqli $db */
if (isset($_POST['submit'])) {
    $date =mysqli_escape_string($db, $_POST['date']);
    $time = mysqli_escape_string($db, $_POST['time']);
    $quantity = mysqli_escape_string($db, $_POST['quantity']);
    $details = mysqli_escape_string($db, $_POST['details']);
    $name = mysqli_escape_string($db, $_POST['org']);


    $errors = [];
    if ($name == "") {
        $errors['org'] = "Vul aub uw naam in";
    }
    if ($date == "") {
        $errors['date'] = "kies een datum";
    }
    if ($quantity == "") {
        $errors['quantity'] = "kies aantal deelnemers";
    }
    if ($details == "") {
        $errors['details'] = "Vul aub de details in";
    }
    if ($time == "") {
        $errors['time'] = "Kies een tijd";
    }

//
    if (empty($errors)) {
        //INSERT in DB
        $query = "INSERT INTO activity (datum , uur, deelnemers, details, naam, vote)
                    VALUES('$date', '$time','$quantity','$details','$name', '0')";
        $result = mysqli_query($db, $query)
        or die('Error: '.mysqli_error($db).' with query: '.$query);

        if ($result) {
            $success = "Hij is toegevoegd aan de DB";
        } else {
            $errors['db'] = mysqli_error($db);
        }
    }


}
mysqli_close($db);



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style/create.css">
</head>
<body>
<div class="container-input">
<form action="" method="post">
    <div class="data-field">
        <label for="date">Datum</label>
        <input id="date" type="date" name="date" placeholder="Datum"
               />
    </div>
    <span><?= $errors['date'] ?? ''  ?></span>

    <div class="data-field ">
        <label for="time">Uur</label>
        <input type="time" id="time" name="time" >
    </div>
    <span><?= $errors['time'] ?? ''  ?></span>

    <div class="data-field ">
        <label for="quantity">Aantal deelnemers</label>
        <input type="number" id="quantity" name="quantity" max="150" >
    </div>
    <span><?= $errors['quantity'] ?? ''  ?></span>


    <div class="data-field ">
        <label for="details">Details</label>
        <input name="details" id="details" placeholder="Details van de activiteit"
               value="<?=  isset($details) ? htmlentities($details): ''  ?>">
    </div>
    <span><?= $errors['details'] ?? ''  ?></span>


    <div class="data-field ">
        <label for="org">Naam organisator</label>
        <input name="org" id="org" placeholder="Naam organisator"
               value="<?=  isset($name) ? htmlentities($name): ''  ?>">
    </div>
    <span><?= $errors['org'] ?? ''  ?></span>


    <button type="submit" name="submit" class="submit">Maak afspraak</button>

</div>

<a href="index.html">terug naar dashboard</a>
</form>

</body>
</html>
