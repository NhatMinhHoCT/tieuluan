<?php
include "header.php";
include "header_nav.php";
?>
<!-- Cart Page Start -->
<div class="container-fluid py-5"></div>
<div class="container-fluid py-5">
  <div class="container py-5">
    <div class="row g-4 justify-content-center">
      <div class="col-sm-12 col-lg-6 col-xl-9">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">STT</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Đơn giá</th>
                <th scope="col" class="text-center">Số lượng</th>
                <th scope="col">Tổng cộng</th>
                <th scope="col">Thao tác</th>
              </tr>
            </thead>
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
              $cartItems = $_SESSION['cart'];
              $total = array_reduce($cartItems, function ($carry, $item) {
                return $carry + ((int)$item['price'] * (int)$item['quantity']);
              }, 0);
              $i = 1;
            ?>
              <tbody>
                <?php foreach ($cartItems as $index => $data) {
                ?>
                  <tr>
                    <th scope="row">
                      <p class="mb-0 mt-4"><?php echo $i ?></p>
                    </th>
                    <th scope="row">
                      <div class="d-flex align-items-center">
                        <img src="../include/upload/<?php echo $data['image'] ?>" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 90px;" alt="">
                      </div>
                    </th>
                    <td>
                      <p class="mb-0 mt-4"><?php echo $data['name'] ?></p>
                    </td>
                    <td>
                      <p class="mb-0 mt-4"><?php echo number_format($data['price'], 0, ',', '.') ?></p>
                    </td>
                    <td>
                      <div class="d-inline-flex align-items-center justify-content-center mt-4">
                        <button class="btn btn-sm btn-minus rounded-circle bg-light border" onclick="decrementValue()">
                          <i class="fa fa-minus"></i>
                        </button>
                        <input type="text" class="form-control form-control-sm text-center w-25 border-0" id="quantityInput" value="<?php echo $data['quantity'] ?>">
                        <button class="btn btn-sm btn-plus rounded-circle bg-light border" onclick="incrementValue()">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
        </div>
        </td>
        <td>
          <p class="mb-0 mt-4"><?php echo number_format(intval($data['price']) * (float)$data['quantity'], 0, ',', '.') ?></p>
        </td>
        <td>
          <button class="btn btn-md rounded-circle bg-light border mt-3" onclick="removeFromCart(<?php echo $index; ?>)">
            <i class="fa fa-times text-danger"></i>
          </button>
        </td>
        </tr>
        </tbody>
    <?php
                  $i++;
                }
              } else {
                echo '<td colspan=6 class="text-center fs-5 my-5 py-5">Bạn chưa có sản phẩm nào trong giỏ hàng</td>';
              }
    ?>
    </table>
      </div>
    </div>
    <div class="col-sm-12 col-lg-6 col-xl-3">
      <div class="bg-light rounded">
        <div class="p-4">
          <h1 class="display-6 mb-4">Giỏ hàng</h1>
          <div class="d-flex justify-content-between mb-4">
            <h5 class="mb-0 me-4">Thành tiền</h5>
            <p class="mb-0"><?php echo isset($total) ? number_format($total, 0, ',', '.') . ' vnd' : '0 vnd'; ?></p>
          </div>
          <div class="d-flex justify-content-between">
            <h5 class="mb-0 me-4">Thuế VAT</h5>
            <div class="">
              <p class="mb-0"><?php echo isset($total) ? number_format($total * 0.1, 0, ',', '.') . ' vnd' : '0 vnd'; ?></p>
            </div>
          </div>

        </div>
        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
          <h5 class="mb-0 ps-4 me-4">Tổng cộng</h5>
          <p class="mb-0 pe-4"><?php echo isset($total) ? number_format($total * 1.1, 0, ',', '.') . ' vnd' : '0 vnd'; ?></p>
        </div>
        <?php
        echo isset($_SESSION['user_id']) ? '<a href="checkout.php" class="btn btn-primary rounded px-4 py-3 text-light text-uppercase mb-4 ms-4" type="button">Thanh toán</a>'
          : '<a class="btn btn-primary rounded py-3 text-light text-uppercase mb-4 ms-4" type="button" data-bs-toggle="modal" data-bs-target="#myModal">
  Thanh toán
</a>';
        ?>
        <button class="btn btn-secondary rounded py-3 text-light text-uppercase mb-4" onclick="history.go(-1)">Trở lại</button>
      </div>
    </div>
  </div>
</div>
</div>
<input type="hidden" id="productIndex" value="<?php echo $index; ?>">

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Thông báo</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Bạn phải đăng ký tài khoản trước khi thanh toán
      </div>
      <div class="modal-footer">
        <a href="signup.php" type="button" class="btn btn-primary text-light">Đăng ký</a>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>
<script>
  function removeFromCart(index) {
    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Define the URL to send the request to
    const url = '../controller/CartController.php';

    // Open the request
    xhr.open('POST', url, true);

    // Set the request header for sending form data
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Define the callback function for handling the server response
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Refresh the page or update the cart display
        location.reload();
      }
    };

    // Send the product index to the server
    xhr.send('index=' + encodeURIComponent(index));
  }

  function incrementValue() {
    const quantityInput = document.getElementById('quantityInput');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + 1;
    quantityInput.value = newValue;

    // Send an AJAX request to update the quantity in the session
    updateQuantityInSession(newValue);
  }

  function decrementValue() {
    const quantityInput = document.getElementById('quantityInput');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue > 1 ? currentValue - 1 : 1;
    quantityInput.value = newValue;

    // Send an AJAX request to update the quantity in the session
    updateQuantityInSession(newValue);
  }

  function updateQuantityInSession(newQuantity) {
    // Create an XMLHttpRequest object
    const xhr = new XMLHttpRequest();

    // Define the URL to send the request to
    const url = '../controller/CartController.php';

    // Open the request
    xhr.open('POST', url, true);

    // Set the request header for sending form data
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Define the callback function for handling the server response
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        // Handle the server response if needed
        console.log(xhr.responseText);
      }
    };

    // Get the product index from the input field
    const productIndex = document.getElementById('productIndex').value;

    // Send the request with the product index and new quantity
    xhr.send('action=updateQuantity&index=' + productIndex + '&quantity=' + newQuantity);
  }
</script>

<!-- Cart Page End -->

<?php
include "footer.php";
?>