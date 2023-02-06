<?php
require_once "includes/db.php";

/** @var mysqli $db */
$query = "SELECT * FROM activity" ;
$result = mysqli_query($db, $query) or die ('Error: ' . $query);

$activities = [];

while($row = mysqli_fetch_assoc($result))
{

    $activities[] = $row;
}



header("Content-Type: application/json");
echo json_encode($activities);
exit;

