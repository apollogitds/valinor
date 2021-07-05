<?php
session_start();
$name = $_POST['name'];
$phone = $_POST['phone'];
$adress = $_POST['adress'];
$comment = $_POST['comment'];
$payment = $_POST['payment'];
$summ = $_POST['summ'];
$purchase = $_POST['purchase'];
if ($comment == NULL) {
  $comment = "—";
}
$token = "1814205866:AAFMs2YBFpZrZuZTSw708Ekri3WUeT_jyPU";
$chat_id = "-556968827";
$arr = array(
  'Имя и фамилия:' => $name,
  'Телефон:' => $phone,
  'Адрес:' => $adress,
  'Комментарий:' => $comment,
  'Заказ:' => $purchase,
  'ИТОГО:' => $summ,
  'Оплата:' => $payment
);
$rfr = 'Æ';
foreach ($arr as $key => $value) {
  $txt .= "<b>" . urlencode($key) . "</b> " . $value . "%0A";
};

$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}", "r");

if ($sendToTelegram) {
  header('Location: thankyou.php');
  foreach ($_SESSION['cart'] as $key => $value) {
    unset($_SESSION['cart'][$key]);
  }
} else {
  echo "Error";
}
