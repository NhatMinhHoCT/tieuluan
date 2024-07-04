<?php

use Controller\AccountController;

include "header.php";
include "header_nav.php";

if (!isset($_SESSION['username'])) {
  echo "<script>window.location.href='404.php'</script>";
}
$account = new AccountController;
$account_data = $account->getAccountInfo($_SESSION['user_id']);


?>
<!-- Checkout Page Start -->
<div class="container-fluid py-5">
  <div class="container py-5">
    <h1 class="mb-4">Thông tin khách hàng</h1>
    <form action="../controller/PaymentController.php" method="POST">
      <div class="row g-5">
        <div class="col-md-12 col-lg-6 col-xl-6">
          <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="form-item w-100">
                <label class="form-label my-3 fw-bolder">Tên khách hàng</label>
                <input type="text" class="form-control" id="shipping_receiver" name="shipping_receiver" value="<?php echo $account_data[0]['guestname'] ?>">
                <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $account_data[0]['account_id'] ?>">
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <div class="form-item w-100">
                <label class="form-label my-3 fw-bolder">Số điện thoại</label>
                <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" value="<?php echo $account_data[0]['phone'] ?>">
              </div>
            </div>
          </div>
          <div class="form-item">
            <label class="form-label my-3 fw-bolder">Địa chỉ giao hàng </label>
            <input type="text" class="form-control" placeholder="Số nhà/đường" id="shipping_address" name="shipping_address" value="<?php echo $account_data[0]['address'] ?>">
          </div>
          <div class="form-item mt-5">
            <textarea name="note" id="note" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Ghi chú (không bắt buộc)"></textarea>
          </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-6">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="text-center">Hình ảnh</th>
                  <th scope="col" class="text-center">Sản phẩm</th>
                  <th scope="col" class="text-center">Giá (đ)</th>
                  <th scope="col" class="text-center">Số lượng</th>
                  <th scope="col" class="pe-0 text-center">Thành tiền (đ)</th>
                </tr>
              </thead>
              <?php
              if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $cartItems = $_SESSION['cart'];
                $total = array_reduce(
                  $cartItems,
                  function ($carry, $item) {
                    return $carry + ((int)$item['price'] * (int)$item['quantity']);
                  },
                  0
                );
              }
              ?>
              <tbody>
                <?php foreach ($cartItems as $index => $data) { ?>
                  <input type="hidden" name="products[<?php echo $index; ?>][id]" value="<?php echo $data['id']; ?>">
                  <input type="hidden" name="products[<?php echo $index; ?>][price]" value="<?php echo $data['price']; ?>">
                  <input type="hidden" name="products[<?php echo $index; ?>][quantity]" value="<?php echo $data['quantity']; ?>">
                  <tr>
                    <th scope="row">
                      <div class="d-flex align-items-center mt-2">
                        <img src="../include/upload/<?php echo $data['image'] ?>" class="img-fluid rounded-circle" style="width: 60px; height: 70px;" alt="">
                      </div>
                    </th>
                    <td>
                      <p class="py-4 mb-0"><?php echo $data['name'] ?></p>
                    </td>
                    <td>
                      <p class="py-4 mb-0"><?php echo number_format($data['price'], 0, ',', '.') ?></p>
                    </td>
                    <td>
                      <p class="py-4  mb-0 text-center"><?php echo $data['quantity'] ?></p>
                    </td>
                    <td>
                      <p class="py-4  mb-0 text-end"><?php echo number_format(intval($data['price']) * (float)$data['quantity'], 0, ',', '.') ?></p>
                    </td>
                  </tr>
                <?php
                } ?>
                <tr>
                  <th scope="row">
                  </th>
                  <td class=""></td>
                  <td class="" colspan="2">
                    <p class="mb-0 text-dark ">Thuế VAT</p>
                  </td>
                  <td class=" text-end">
                    <p class="mb-0 text-dark "><?php echo isset($total) ? number_format($total * 0.1, 0, ',', '.') : '0'; ?></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                  </th>
                  <td class="">
                    <p class="mb-0 text-dark text-uppercase fs-5 fw-bold">Tổng cộng</p>
                  </td>
                  <td class=""></td>
                  <td class=""></td>
                  <td class=" text-end">
                    <div class=" text-end">
                      <p class="mb-0 text-dark"><?php echo isset($total) ? number_format($total * 1.1, 0, ',', '.') : '0'; ?></p>
                      <input type="text" name="total_amount" id="total_amount" value="<?php echo isset($total) ? number_format($total * 1.1, 0, ',', '.') : '0'; ?>" hidden>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div>
            <!-- <form action="../controller/PaymentController.php" method="POST"> -->
            <p>Chọn phương thức thanh toán</p>
            <div class="row g-4 text-center align-items-center justify-content-center">
              <div class="col-12">
                <div class="form-check text-start ">
                  <input type="checkbox" class="form-check-input" id="COD" name="COD" value="COD">
                  <label class="form-check-label" for="Delivery-1">Thanh toán COD</label>
                </div>
              </div>
            </div>
            <div class="row g-4 text-center align-items-center justify-content-center py-3">
              <div class="col-12">
                <div class="form-check text-start">
                  <input type="checkbox" class="form-check-input" id="payUrl" name="payUrl" value="payUrl">
                  <label class="form-check-label" for="payUrl">Thanh toán qua MoMo</label>
                </div>
              </div>
            </div>
            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
              <button type="submit" name="submit" class="btn border-secondary py-3 px-4 text-uppercase text-primary">Đặt hàng</button>
            </div>
            <!-- </form> -->
          </div>
        </div>
    </form>
  </div>
</div>
<?php

?>
<!-- Checkout Page End -->
<script>

</script>

<?php
include "footer.php";
?>