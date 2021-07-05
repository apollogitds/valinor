<?php
session_start();
require_once "db.php";
require_once "functions.php";

$query = "SELECT * FROM milk";
$req = mysqli_query($connection, $query);
$data_from_db = [];

while ($result = mysqli_fetch_assoc($req)) {
    $data_from_db[] = $result;
}
?>