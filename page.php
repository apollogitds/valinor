<?php
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
?>

<!DOCTYPE html>
<html>
<script src="js/jquery-3.6.0.min.js?<?= filemtime('js/jquery-3.6.0.min.js') ?>"></script>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
    <link rel="icon" href="icon.png">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <title>Молочные продукты и яйца</title>
</head>

<body id="qwe">

    <div class="container">
        <header>
            <img src="s/header.jpg" class="logo">
            <figure><img src="s/loc.png">
                <figcaption style="z-index: 1;">
                    <p style="color: #fff; font-size: 20px;">Нижний Новгород,<br>пл. Минина и
                        Пожарского, д. 1</p>
                </figcaption>
                <img src="s/phone.png">
                <figcaption>
                    <p style="color: #fff; font-size: 30px; padding-left: 45px;">8 (800) 392-77-60</p>
                </figcaption>
            </figure>
            <a href="index.php"><img src="s/logo.png" class="logo"></a>
            <?php
            echo '<a href="cart.php"><img src="s/carticon.png" class="logo" title="' . $summ . '"></a>';
            if (isset($_SESSION['cart']) && $cart_quantity != 0) {
                echo '<div id="cq" class="cart badgec">' . $cart_quantity . '</div>';
            }
            ?>
            <div class="menu">
                <ul class="ul-menu">
                    <li class="li-menu"><a href="1.php">Молочные продукты и яйца</a></li>
                    <li class="li-menu"><a href="2.php">Хлеб и выпечка</a></li>
                    <li class="li-menu"><a href="3.php">Мясо</a></li>
                    <li class="li-menu"><a href="4.php">Напитки</a></li>
                    <li class="li-menu"><a href="5.php">Мёд</a></li>
                    <li class="li-menu"><a href="6.php">Фрукты и овощи</a></li>
                    <li class="li-menu"><a href="7.php">Чай и травы</a></li>
                    <li class="li-menu"><a href="8.php">Готовые блюда</a></li>
                    <li class="li-menu"><a href="9.php">Полуфабрикаты</a></li>
                </ul>
            </div>
        </header>

        <div class="mcontent">
            <div class="name">
                <h1><?php echo $title ?></h1>
            </div>
            <section>
                <!-- -->
                <div class="container px-4 px-lg-5 mt-5">
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                        <form action="" method="POST" id="add">

                            <?php
                            foreach ($data_from_db as $item_piece) {
                                echo '
                            <div class="col mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="' . $item_piece["pic"] . '" />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h4 class="fw-bolder">' . $item_piece["name"] . '</h4>
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                    <form>
                                        <button id="' . $item_piece["id"] . '" class="add_to_cart btn btn-outline-dark" style="border: 0; font-family: Playfair Display, serif;">' . $item_piece["price"] . ' руб.</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            ';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <footer class="bg-dark">
            <div class="footer">
                ООО «Валинор Ритейл». Адрес: 603005, г. Нижний Новгород, пл. Минина и Пожарского, д. 1<br>
                Контакты: 8 (800) 392-77-60, valinorfarm@gmail.com
            </div>
        </footer>
</body>
<script src="js/no_reload.js?<?= filemtime('js/no_reload.js') ?>"></script>

</html>