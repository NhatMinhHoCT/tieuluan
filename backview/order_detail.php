<?php

use Controller\AccountController;
use Controller\OrderController;

include "header.php";
$page_title = "donhang";
include "navside.php";
$order = new OrderController;
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $order_data = $order->getOrderById($id);
  $total = array_reduce(
    $order_data,
    function ($carry, $item) {
      return $carry + ((int)$item['price'] * (int)$item['quantity']);
    },
    0
  );
}
if (isset($_POST['capnhat'])) {
  $id = $_POST['order_id'];
  $state = $_POST['state'];
  if ($order->updateOrder($id, $state)) {
    echo '<script>
    window.location.href = "order_detail.php?id=' . $id . '";
  </script>';
    $_SESSION['success'] = 2;
  } else {
    echo '<script>
  setTimeout(function () {
  showToast("Thất bại", "Cập nhật trạng thái đơn hàng không thành công", "error")
  },1000)
  </script>';
  }
}
if (isset($_SESSION['success']) && ($_SESSION['success'] == 2)) {
  echo '<script>
  setTimeout(function () {
  showToast("Thành công", "Cập nhật trạng thái đơn hàng thành công", "success")
  },100)
  </script>'; 
  unset($_SESSION['success']);
}
?>
<!-- Checkout Page Start -->
<div class="container-fluid">
  <div class="container py-5">
    <div class="row g-5">
      <div class="col-md-12 col-lg-6 col-xl-6">
        <div class="row">
          <div class="col-md-12 col-lg-6">
            <div class="form-item w-100">
              <label class="form-label my-3 fw-bolder">Tên người nhận</label>
              <input type="text" class="form-control" value="<?php echo $order_data[0]['shipping_receiver'] ?>">
            </div>
          </div>
          <div class="col-md-12 col-lg-6">
            <div class="form-item w-100">
              <label class="form-label my-3 fw-bolder">Số điện thoại</label>
              <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" value="<?php echo $order_data[0]['shipping_phone'] ?>">
            </div>
          </div>
        </div>
        <div class="form-item">
          <label class="form-label my-3 fw-bolder">Địa chỉ giao hàng </label>
          <input type="text" class="form-control" placeholder="Số nhà/đường" id="shipping_address" name="shipping_address" value="<?php echo $order_data[0]['shipping_address'] ?>">
        </div>
        <div class="form-item mt-5">
          <textarea name="note" id="note" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Ghi chú (không bắt buộc)">
              <?php echo $order_data[0]['note'] ?>
            </textarea>
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
            <tbody>
              <?php foreach ($order_data as $index => $data) { ?>
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
        <div class="container-fluid py-3">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div class="row g-5 d-flex-inline">
              <label class="form-label fw-bolder col-5 pt-2">Trạng thái đơn hàng</label>
              <div class="col-7">
                <select class="form-select" aria-label="Default select example" id="state" name="state">
                  <option value="1">Đang xử lý</option>
                  <option value="2">Đang giao hàng</option>
                  <option value="3">Đã giao hàng</option>
                </select>
              </div>
              <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_data[0]['order_id'] ?>">
            </div>
            <div class="text-center mt-4">
              <button id="order_stage_update" class="btn btn-primary text-light" name="capnhat" type="submit">Cập nhật</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
  <!-- Checkout Page End -->
  <script>
    $(document).ready(function() {
      let state = <?php echo $order_data[0]['state']; ?>;
      $('#state option').each(function() {
        if ($(this).val() == state) {
          $(this).prop('selected', true);
        }
      });
    });
  </script>
  <?php
  include "footer.php";
  ?>