<?php

namespace Controller;

use Model\Database;

require_once "../vendor/autoload.php";

class PaymentController
{
  public function __construct()
  {
  }
  public function execPostRequest($url, $data)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
      )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
  }

  public function momoPayment()
  {
    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    $partnerCode = 'MOMOBKUN20180529';
    $accessKey = 'klm05TvNBzhg7h7j';
    $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    $orderInfo = "Thanh toán qua MoMo";
    $amount = "10000";
    $orderId = time() . "";
    $redirectUrl = "http://localhost/tieuluan/view/success.php";
    $ipnUrl = "http://localhost/tieuluan/view/index.php";
    $extraData = "";

    $serectkey = $secretKey;
    // $partnerCode = $_POST["partnerCode"];
    // $accessKey = $_POST["accessKey"];
    // $orderId = $_POST["orderId"]; // Mã đơn hàng
    // $orderInfo = $_POST["orderInfo"];
    // $amount = $_POST["amount"];
    // $ipnUrl = $_POST["ipnUrl"];
    // $redirectUrl = $_POST["redirectUrl"];
    // $extraData = $_POST["extraData"];

    $requestId = time() . "";
    $requestType = "payWithATM";
    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $serectkey);
    $data = array(
      'partnerCode' => $partnerCode,
      'partnerName' => "Test",
      "storeId" => "MomoTestStore",
      'requestId' => $requestId,
      'amount' => $amount,
      'orderId' => $orderId,
      'orderInfo' => $orderInfo,
      'redirectUrl' => $redirectUrl,
      'ipnUrl' => $ipnUrl,
      'lang' => 'vi',
      'extraData' => $extraData,
      'requestType' => $requestType,
      'signature' => $signature
    );
    $result = $this->execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there

    header('Location: ' . $jsonResult['payUrl']);
  }
  public function insertOrders($order_code, $customer_id, $shipping_receiver, $shipping_phone, $shipping_adress, $total_amount, $order_date, $payment_method, $note, $state)
  {
    $db = new Database();
    $sql = "INSERT INTO orders (order_code, customer_id, shipping_receiver, shipping_phone, shipping_address, total_amount,order_date, payment_method, note, state)
    VALUES ('$order_code','$customer_id','$shipping_receiver','$shipping_phone', '$shipping_adress', '$total_amount', '$order_date','$payment_method', '$note', '$state')";
    return $db->insert_lastid($sql);
  }
  public function insertOrdersDetail($order_id, $product_id, $quantity, $price)
  {
    $db = new Database();
    $sql = "INSERT INTO order_detail (order_id, product_id, quantity, price)
    VALUES ('$order_id','$product_id', '$quantity', '$price')";
    return $db->execute($sql);
  }
}
$payment = new PaymentController;
if (isset($_POST['submit'])) {
  $customer_id = $_POST['customer_id'];
  $shipping_receiver = $_POST['shipping_receiver'];
  $shipping_phone = $_POST['shipping_phone'];
  $shipping_address = $_POST['shipping_address'];
  $total_amount = $_POST['total_amount'];
  $order_date = date('Y-m-d H:i:s');;
  $note = isset($_POST['note']) ? $_POST['note'] : '';
  $products = $_POST['products'];
  $state = 1;
  $order_code= 'EW-'.rand(10,99).chr(rand(65,90)). chr(rand(65, 90)). rand(10, 99);
  if (isset($_POST['payUrl'])) {
    $payment_method = 'Momo';
    $order_id = $payment->insertOrders($order_code,$customer_id, $shipping_receiver, $shipping_phone, $shipping_address, $total_amount, $order_date, $payment_method, $note, $state);
    foreach ($products as $product) {
      $product_id = $product['id'];
      $price = $product['price'];
      $quantity = $product['quantity'];
      $payment->insertOrdersDetail($order_id, $product_id, $quantity, $price);
    }
    $payment->momoPayment($_POST['payUrl']);
  } else 
  if (isset($_POST['COD'])) {
    $payment_method = 'COD';
    $order_id = $payment->insertOrders($order_code, $customer_id, $shipping_receiver, $shipping_phone, $shipping_address, $total_amount, $order_date, $payment_method, $note, $state);
    foreach ($products as $product) {
      $product_id = $product['id'];
      $price = $product['price'];
      $quantity = $product['quantity'];
      $payment->insertOrdersDetail($order_id, $product_id, $quantity, $price);
    }
    session_start();
    unset($_SESSION['cart']);
    header('Location: ../view/success.php');
  }
}
