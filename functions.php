<?php
require_once "db.php";

function get_item_by_id($id)
{
    global $connection;
    global $table_name;

    $query = "SELECT * FROM $table_name WHERE id=" . $id;
    $req = mysqli_query($connection, $query);
    $resp = mysqli_fetch_assoc($req);

    return $resp;
}
