<?php
session_start();
require_once "db.php";
$query = "SELECT * FROM milk";
$req = mysqli_query($connection, $query);
$data_from_db = [];

while ($result = mysqli_fetch_assoc($req)) {
    $data_from_db[] = $result;
}

$count = count($_SESSION['cart']);
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

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/index.css" type="text/css" media="screen">
    <link rel="icon" href="icon.png">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <title>Валинор</title>
</head>

<body>
    <!-- <audio src="s/yello.mp3" autoplay="autoplay" volume="-1000"></audio> -->
    <div class="container">
        <header>
            <img src="s/header.jpg" class="logo">
            <figure><img src="s/loc.png">
                <figcaption style="z-index: 1;">
                    <p style="color: #fff; font-size: 20px;">Нижний Новгород, <br> пл. Минина и
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
                echo '<div class="cart badgec">' . $cart_quantity . '</div>';
            }
            ?>
            <h1>Доставка фермерских продуктов</h1>
        </header>
        <div>
            <img src="s/board.png" style="width: 100%;" />
        </div>
        <div class="mcontent">
            <h1 style="background-color: transparent; color: white;">Разделы<br></h1>

            <div class="cont1">
                <a href="1.php"><img src="s/1o.png">
                    <p><b>Молочные продукты и яйца</b></p>
                </a>
                <a href="2.php"><img src="s/2o.png">
                    <p><b>Хлеб и выпечка</b></p>
                </a>
                <a href="3.php"><img src="s/3o.png">
                    <p><b>Мясо</b></p>
                </a>
                <a href="4.php"><img src="s/4o.png">
                    <p><b>Напитки</b></p>
                </a>
                <a href="5.php"><img src="s/5o.png">
                    <p><b>Мёд</b></p>
                </a>
            </div>

            <div class="cont2">
                <a href="6.php"><img src="s/6o.png">
                    <p><b>Фрукты и овощи</b></p>
                </a>
                <a href="7.php"><img src="s/7o.png">
                    <p><b>Чай и травы</b></p>
                </a>
                <a href="8.php"><img src="s/8o.png">
                    <p><b>Готовые блюда</b></p>
                </a>
                <a href="9.php"><img src="s/9o.png">
                    <p><b>Полуфабрикаты</b></p>
                </a>
            </div>
        </div>
    </div>
    <div>
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A6527ed32518f86d7c0d040e0f431d0771eb43bf434b550695f3e9f28a02dda9a&amp;width=100%25&amp;height=264&amp;lang=ru_RU&amp;scroll=true"></script>
    </div>

    <footer class="bg-dark">
        <div class="footer">
            ООО «Валинор Ритейл». Адрес: 603005, г. Нижний Новгород, пл. Минина и Пожарского, д. 1<br>
            Контакты: 8 (800) 392-77-60, valinorfarm@gmail.com
        </div>
    </footer>
</body>

</html>