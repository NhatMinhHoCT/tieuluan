<?php

namespace controller;

session_start();
class CartController
{
  public function __construct()
  {
    // Check if the product data is received
    if (isset($_POST['idInput']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['quantity'])) {
      $productName = $_POST['name'];
      $productPrice = $_POST['price'];
      $productQuantity = $_POST['quantity'];
      $productId = $_POST['idInput'];
      $productImage = $_POST['imageInput'];
      // Call the method to store the product in the cart
      $this->storeProductInCart($productId, $productName, $productPrice, $productQuantity, $productImage);
      // Redirect back to the product detail page
      $url = "../view/productdetail.php?id=$productId";
      header("Location: $url");
      exit();
    }
  }

  public function storeProductInCart($id, $name, $price, $quantity, $image)
  {
    // Check if the cart session variable exists
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = array();
    }

    // Create a product array
    $product = array(
      'id' => $id,
      'name' => $name,
      'price' => $price,
      'quantity' => $quantity,
      'image' => $image,
    );

    // Add the product to the cart session variable
    $_SESSION['cart'][] = $product;
  }
}
// Check if the product index is received
if (isset($_POST['index'])) {
  $index = $_POST['index'];

  // Check if the cart session variable exists and is not empty
  if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Remove the product from the cart session variable
    unset($_SESSION['cart'][$index]);

    // Reindex the cart array
    $_SESSION['cart'] = array_values($_SESSION['cart']);
  }
}

// Create an instance of the CartController
$cartController = new CartController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['action']) && $_POST['action'] === 'updateQuantity') {
    $index = $_POST['index'];
    $newQuantity = $_POST['quantity'];

    // Check if the cart session variable exists and is not empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
      // Update the quantity of the product in the cart session variable
      $_SESSION['cart'][$index]['quantity'] = $newQuantity;
    }
  }
}
