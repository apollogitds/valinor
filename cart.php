<?php
session_start();
$table_name = "milk";
require_once "db.php";
require_once "functions.php";
if (isset($_GET['delete_id']) && isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        if ($value['id'] == $_GET['delete_id']) {
            unset($_SESSION['cart'][$key]);
        }
    }
}


if (isset($_POST['minus_id']) && !empty($_POST['minus_id'])) {
    $current_minus_item = get_item_by_id($_POST['minus_id']);

    if (!empty($current_minus_item)) {
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($value['id'] == $current_minus_item['id']) {
                    $_SESSION['cart'][$key]['num']--;
                    if ($_SESSION['cart'][$key]['num'] == 0) {
                        unset($_SESSION['cart'][$key]);
                        header("Location: " . $_SERVER["PHP_SELF"]);
                    }
                }
            }
        }
    }
    header("Location: " . $_SERVER["PHP_SELF"]);
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
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($value['id'] == $current_added_item['id']) {
                    $item_check = true;
                    $_SESSION['cart'][$key]['num']++;
                }
            }
        }

        if (!$item_check) {
            $current_added_item['num'] = 1;
            $_SESSION['cart'][] = $current_added_item;
        }
    }
    header("Location: " . $_SERVER["PHP_SELF"]);
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

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
    <link rel="icon" href="icon.png">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <title>Корзина</title>
</head>

<body>
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
            echo '<a href="cart.php"><img src="s/carticon.png" class="logo" title="' . $summ . '"></a>
            ';
            if (isset($_SESSION['cart']) && $cart_quantity != 0) {
                echo '<div class="cart badgec">' . $cart_quantity . '</div>';
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
                <h1 style="margin-bottom: 30px;">Корзина</h1>
            </div>
            <table style="width: 100%;">
                <tr style="top: 0 !important;">
                    <td style="width: 60%; vertical-align: top;">
                        <section>
                            <div class="container">
                                <?php
                                if (isset($_SESSION['cart']) && count($_SESSION['cart']) != 0) {
                                    echo  '<div class="row gx-4 gx-lg-2 row-cols-2 row-cols-md-3 row-cols-xl-4">';
                                    $i = 1;
                                    foreach ($_SESSION['cart'] as $item) {
                                        $purchase .= "%0A" . $i . ") " . $item["name"]  . " | " . $item["num"] . "*" . $item["price"] . " = " . $item["price"] * $item["num"] . " руб.";
                                        $i++;
                                        echo '
                                            <div class="col mb-5">
                                            <div class="card h-100">
                                                <div class="badgec bg-dark text-white position-absolute" style="top: 0rem; left: 0.4rem; font-size: 1.2em;">' . $item["num"] . '</div>
                                                <div class="btnc badgec position-absolute" style="right: 0.5rem; font-size: 1.5em; background-color: transparent; 
                                                    padding-right: 6px; padding-top: 0;"><a style="text-decoration: none; color: #000" href="cart.php?delete_id=' . $item["id"] . '">×</a>
                                                </div>
                                                <div class="btnc position-absolute" style="top: 0rem; left: 0.5rem; margin-top: 5rem; font-size: 1.5em; 
                                                    padding: 0;">
                                                    <form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
                                                        <button name="minus_id" value="' . $item["id"] . '" style="border: 0; background-color: transparent"><img style="width: 100%;" src="s/minus.png"></button>
                                                    </form>
                                                </div>
                                                <div class="btnc position-absolute" style="top: 0rem; right: 0.5rem; margin-top: 5rem; font-size: 1.5em; 
                                                padding: 0;">
                                                <form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
                                                     <button name="item_id" value="' . $item["id"] . '" style="border: 0; background-color: transparent"><img style="width: 100%;" src="s/plus.png"></button>
                                                </form>
                                                </div>
                                                <img class="card-img-top" src="' . $item["pic"] . '" />
                                                <div class="p-4">
                                                    <div class="text-center">
                                                        <h5 class="fw-bolder" style="margin-right: 1em; margin-left: 1em;">' . $item["name"] . '</h5>
                                                    </div>
                                                </div>
                                                <div class="p-4 pt-0 border-top-0 bg-transparent">
                                                    <div class="text-center">
                                                        <h2 style="color: black;">' . $item["price"] . '
                                                            р.</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            ';
                                    }
                                } else {
                                    $cart_is_empty = 1;
                                    echo '
                                        <h2 style="text-align: center; opacity: 0.5">Пусто</h2>
                                        ';
                                }
                                ?>

                            </div>
                        </section>
                    </td>
                    <td style="width: 40%; padding-left: 3%; vertical-align: top;">
                        <div style="color: black; justify-content: left;">
                            <table>
                                <td>
                                    <p style="color: black; font-size: 2em; padding-bottom: 0; padding-top: -5;">
                                    <h2>Сумма</h2>
                                    </p>
                                </td>
                                <td style="vertical-align: middle;">
                                    <p style="color: black; margin-left: 5px; margin-top: 0;">+149 руб. за доставку</p>
                                </td>
                </tr>
            </table>
            <h1 style="padding-top: 0; font-size: 3.5em; background-color: #ffdf01; padding-bottom: 16px; margin: 10px 0px;"><?php echo $summ; ?> руб.</h1>
        </div>

        <?php if (!$cart_is_empty) : ?>
            <h2>Оформление заказа</h2>
            <form action="telegram.php" method="POST">
                <input required type="text" class="form-control" placeholder="Имя и фамилия" name="name">
                <input required type="text" class="form-control" placeholder="Номер телефона" name="phone">
                <input required type="text" class="form-control" placeholder="Адрес доставки: улица, дом, квартира" name="adress">
                <input type="text" class="form-control" placeholder="Комментарий к заказу " name="comment">
                <input type="hidden" name="summ" value="<?php echo $summ ?> руб.">
                <input required type="hidden" name="purchase" value="<?php echo $purchase ?>">
                <div class="form-group">
                    <label style="font-weight: 700 !important;">
                        <h3>Способ оплаты</h3>
                    </label>
                    <div class="radio">
                        <label class="radio-inline">
                            <input required type="radio" name="payment" style="margin-right: 3px" value="Наличными">Наличными</label><a></a>
                        <label class="radio-inline">
                            <input required type="radio" name="payment" style="margin-left: 10px; margin-right: 3px" value="Картой">Картой</label>
                    </div>
                    <p></p>
                </div>
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <button type="submit" name="" value="" class="btn btn-outline-dark" style="width: 100%; margin-bottom: 40px; border: 0; font-family: Playfair Display, serif;">Заказать</button>
                </div>
            </form>
            </td>
        <?php else : ?>
            <h3 style="text-align: center; opacity: 0.5">добавьте товар в корзину</h2>
            <?php endif; ?>

            </tr>
            </table>
    </div>
    <footer class="bg-dark">
        <div class="footer">
            ООО «Валинор Ритейл». Адрес: 603005, г. Нижний Новгород, пл. Минина и Пожарского, д. 1<br>
            Контакты: +7 (800) 392-77-60, valinorfarm@gmail.com
        </div>
    </footer>
</body>

</html>