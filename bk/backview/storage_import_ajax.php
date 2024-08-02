<?php
require_once "../vendor/autoload.php";
use Controller\ProductController;

$idSupplier = array($_POST['idSupplier']);
// $idSupplier = explode(",", $_POST['idSupplier']);

// var_dump($idSupplier);
$product = new ProductController;
$row = $product->getProduct(null, $idSupplier, null, null, null, null, null, 4);
echo '
<div class="form-floating mb-3">
              <select class="form-select pb-2" id="idProduct" name="idProduct" aria-label="Floating label select example">
              <option selected disabled value="">Chọn sản phẩm</option>';
foreach ($row as $data) {
  echo '
<option value="' . $data->idProduct . '">'.$data->name.'</option>
';
}
echo '
              </select>
              <label for="floatingSelect">Sản phẩm</label>
            </div>
';
