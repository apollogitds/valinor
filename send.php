<?php
session_start();

$table_name = "milk";
require_once "db.php";
require_once "functions.php";

$query = "SELECT * FROM $table_name";
$req = mysqli_query($connection, $query);
$data_from_db = [];

while ($result = mysqli_fetch_assoc($req)) {
    $data_from_db[] = $result;
}

//
$count = count($_SESSION['cart']);

if (isset($_POST['delete_id']) && isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $_POST['delete_id']) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

if (isset($_POST['item_id']) && !empty($_POST['item_id'])) {

    $current_added_item = get_item_by_id($_POST['item_id']);

    if (!empty($current_added_item)) {
        if (!isset($_SESSION['cart'])) {
            $current_added_item['num'] = 1;
            $_SESSION['cart'][] = $current_added_item;
        }

        $item_check = false;

        if (isset($_SESSION['cart'])) {
            header("Location: " . $_SERVER["PHP_SELF"]);
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($value['id'] == $current_added_item['id']) {
                    $item_check = true;
                    $_SESSION['cart'][$key]['num']++;
                }
            }
            var_dump($_SESSION['cart']);
        }
        if (!$item_check) {
            header("Location: " . $_SERVER["PHP_SELF"]);
            $current_added_item['num'] = 1;
            $_SESSION['cart'][] = $current_added_item;
            var_dump($_SESSION['cart']);
        }
    }
}
foreach ($_SESSION['cart'] as $key => $value) {
    $cart_quantity = $cart_quantity + $_SESSION['cart'][$key]['num'];
}

$summ = 0;
foreach ($_SESSION['cart'] as $key => $value) {
    $summ += $_SESSION['cart'][$key]['price'] * $_SESSION['cart'][$key]['num'];
}
if ($summ > 0) {
    $summ += 149;
}
