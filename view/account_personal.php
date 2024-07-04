<?php
include "header.php";
include "header_nav.php";

use Controller\OrderController;
use Controller\AccountController;

if (!isset($_SESSION['username'])) {
  echo "<script>window.location.href='404.php'</script>";
}

$account = new AccountController();
$account_data = $account->getAccountInfo($_SESSION['user_id'])[0];
$orders = new OrderController();
// if (isset($_POST['capnhat'])) {
//   $old_password = $_POST['old_password'];
//   $new_password = $_POST['new_password'];
//   $idAccount = $_SESSION['user_id'];
//   if ($account->changePassword($idAccount, $old_password, $new_password)) {
//     echo "<script>
//     console.log('ok');
//     </script>";
//     //   echo '<script>
//     // setTimeout(function () {
//     // showToast("Thành công", "Cập nhật mật khẩu thành công", "success")
//     // },1000)
//     // </script>';
//   } else {

//     echo "<script>
//     console.log('not ok');
//     </script>";
//     //   echo '<script>
//     // setTimeout(function () {
//     // showToast("Lỗi", "Cập nhật mật khẩu không thành công", "error")
//     // },1000)
//     // </script>';
//   }
// }

?>

<div class="container py-5 mt-5">
  <div class="container">
    <div class="pb-5">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Tài khoản cá nhân</a></li>
      </ol>
    </div>
    <div class="container">
      <div class="row g-4 mb-5">
        <div class="col-lg-5 col-xl-4">
          <div class="row g-1 fruite">
            <div class="col-lg-12 displayform px-4">
              <div class="text-center">
                <img class="rounded-circle me-lg-2" src="../include/img/banner1.png" alt="" style=" width: 100px; height: 100px;">
              </div>
              <div>
                <h4 class="text-center my-3"><?php echo $account_data['guestname'] ?? $account_data['username'] ?></h4>
              </div>
              <p class="fs-5 fw-bold">Thông tin </p>
              <hr>
              <ul style="list-style: none;" class="ps-0">
                <li class="mb-3"><span class="fw-bold">Tên tài khoản: </span><span><?php echo $account_data['username'] ?></span></li>
                <li class="mb-3"><span class="fw-bold">Email: </span><span><?php echo $account_data['email'] ?></span></li>
                <li class="mb-3"><span class="fw-bold">Số điện thoại: </span><span><?php echo $account_data['phone'] ?? '' ?></span></li>
                <li class="mb-3"><span class="fw-bold">Địa chỉ: </span><span><?php echo $account_data['address'] ?? '' ?></span></li>

              </ul>
              <div class="text-center my-3 pt-3">
                <button id="info_update" class="btn btn-primary text-light">
                  Cập nhật
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-xl-8">
          <div class="row g-4">
            <div class="col-lg-12">
              <nav>
                <div class="nav nav-tabs mb-3">
                  <button class="nav-link active border-white border-bottom-0" type="button" role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">
                    Đơn hàng của tôi <i class="fa fa-shopping-cart"></i></button>
                  <button class="nav-link border-white border-bottom-0" type="button" role="tab" id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission" aria-controls="nav-mission" aria-selected="false">
                    Bảo mật <i class="fa fa-lock"></i></button>
                </div>
              </nav>
              <div class="tab-content mb-5">
                <div class="tab-pane active displayform" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                  <h5>Danh sách đơn hàng</h5>
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
                    <div class="row">
                      <div class="col-8"></div>
                      <div class=" d-flex col-4 mb-3">
                        <input id="search" type="search" name="search" class="form-control" placeholder="Tìm kiếm" aria-describedby="search-icon-1" value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
                        <button type="submit" class="btn btn-outline-primary mx-2"><i class="fa fa-search"></i></button>
                        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" type="submit" class="btn btn-outline-dark"><i class="fa fa-eraser"></i></a>
                      </div>
                    </div>
                  </form>
                  <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                      <thead>
                        <tr class="text-primary">
                          <th scope="col">Ngày tạo</th>
                          <th scope="col">Mã đơn hàng</th>
                          <th scope="col">Tổng tiền</th>
                          <th scope="col">Phương thức</th>
                          <th scope="col">Trạng thái</th>
                          <th scope="col">Thao tác</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $limit = 5;
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($currentPage - 1) * $limit;
                        if (isset($_GET['search'])) {
                          $search = $_GET['search'] ?? null;
                          $row = $orders->getOrderAll($_SESSION['user_id'], $search, $start, $limit);
                          $totalItems = $orders->countOrderAll($_SESSION['user_id'], $search);
                        } else {
                          $row = $orders->getOrderAll($_SESSION['user_id'], null, $start, $limit);
                          $totalItems = $orders->countOrderAll($_SESSION['user_id'], null);
                        }

                        $totalPages = ceil($totalItems / $limit);
                        if ($row != null) {
                          foreach ($row as $data) {
                        ?>
                            <tr>
                              <td><?php echo date_format(date_create($data->order_date), 'd/m/Y') ?></td>
                              <td><?php echo $data->order_code ?></td>
                              <td><?php echo $data->total_amount ?></td>
                              <td><?php echo $data->payment_method ?></td>
                              <td><?php
                                  switch ($data->state) {
                                    case '1':
                                      $stage_text = "Đang xử lý";
                                      break;
                                    case '2':
                                      $stage_text = "Đang giao hàng";
                                      break;
                                    case '3':
                                      $stage_text = "Đã giao hàng";
                                      break;
                                    default:
                                      # code...
                                      break;
                                  };
                                  echo $stage_text ?></td>
                              <td><a href="order_detail.php?id=<?php echo $data->idOrder?>" class="btn btn-sm btn-primary text-light" href="">Chi tiết</a></td>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                    <div class="col-12">
                      <?php
                      $queryParams = array(
                        'search' => $_GET['search'] ?? '',
                      );
                      $query = http_build_query($queryParams);
                      echo '<div class="pagination d-flex justify-content-center mt-5">';

                      if ($currentPage > 1) {
                        $prevPage = $currentPage - 1;
                        echo '<a href="?' . $query . '&page=' . $prevPage . '" class="rounded">&laquo;</a>';
                      }

                      for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = ($i == $currentPage) ? 'active' : '';
                        echo '<a href="?' . $query . '&page=' . $i . '" class="rounded ' . $activeClass . '">' . $i . '</a>';
                      }
                      if ($currentPage < $totalPages) {
                        $nextPage = $currentPage + 1;
                        echo '<a href="?' . $query . '&page=' . $nextPage . '" class="rounded">&raquo;</a>';
                      }
                      echo '</div>';
                      ?>
                    </div>
                  </div>

                </div>
                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                  <div class="displayform px-4">
                    <h5>Đổi mật khẩu</h5>
                    <form id="change_pass_form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                      <div class="row mb-3">
                        <label for="old_password" class="col-sm-4 col-form-label">Mật khẩu cũ</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="old_password" id="old_password">
                          <div id="error_old_password" class="error"></div>
                        </div>

                      </div>
                      <div class="row mb-3">
                        <label for="new_password" class="col-sm-4 col-form-label">Mật khẩu mới</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="new_password" id="new_password">
                          <div id="error_new_password" class="error"></div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="password_confirm" class="col-sm-4 col-form-label">Nhập lại mật khẩu</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="password_confirm" id="password_confirm">
                          <div id="error_conf_password" class="error"></div>
                        </div>
                      </div>
                      <div class="text-center my-3">
                        <button id="change_pass_btn" class="btn btn-primary text-light" type="submit" name="capnhat">Cập nhật</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
if (isset($_POST['update_info'])) {
  $guestname = $_POST['guestname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $idAccount = $_SESSION['user_id'];
  if ($account->updateAccountInfo($idAccount, $guestname, $email, $phone, $address)) {
    echo '<script>
    window.location.href = "account_personal.php";
     </script>';
     $_SESSION['success']=2;
  // setTimeout(function () {
  // showToast("Thành công", "Cập nhật thông tin thành công", "success")
  // },1000)
  // </script>';
  }
}
if (isset($_SESSION['success']) && $_SESSION['success'] == 2) {
  echo '<script>
    showToast("Thành công", "Cập nhật thông tin thành công", "success");
    </script>';

  // Set a timestamp in the session to track when the toast was displayed
  $_SESSION['toast_displayed_time'] = time();
}

// Check if the toast was displayed 5 seconds ago
if (isset($_SESSION['toast_displayed_time']) && (time() - $_SESSION['toast_displayed_time']) >= 1) {
  // Unset the success session variable
  unset($_SESSION['success']);

  // Unset the timestamp session variable
  unset($_SESSION['toast_displayed_time']);
}
?>


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
      <div class="modal-header mt-5">
        <h2 class="mx-auto">Thông tin cá nhân</h2>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="my-3 col-6">
            <label for="guestname" class="form-label">Tên khách hàng</label>
            <input type="text" class="form-control" id="guestname" name="guestname" aria-describedby="emailHelp" value="<?php echo $account_data['guestname'] ?>">
          </div>
          <div class="my-3 col-6">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $account_data['phone'] ?>">
          </div>
          <div class="my-3 col-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $account_data['email'] ?>">
          </div>
          <div class="my-3 col-6">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $account_data['address'] ?>">
          </div>
        </div>
      </div>
      <div class="modal-footer ">
        <div class="mx-auto my-5">
          <button class="btn btn-primary text-light" id="update_info" name="update_info" type="submit">Cập nhật</button>
          <button class="btn btn-danger" id="close">Đóng</button>
        </div>
      </div>
    </form>
  </div>

</div>

<script>
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var btn = document.getElementById("change_pass_btn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
  $(document).ready(function() {
    $('#info_update').click(function() {
      $('#myModal').css("display", "block");
      span.onclick = function() {
        modal.style.display = "none";
      }
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    });
  });



  // $(document).ready(function() {
  //   // Event listener for the change password button click
  //   $("#change_pass_form").submit(function(e) {
  //     // e.preventDefault(); // Prevent the default form submission

  //     // Get the values of the input fields
  //     const oldPassword = $('#old_password').val();
  //     const newPassword = $('#new_password').val();
  //     const passwordConfirm = $('#password_confirm').val();

  //     // Reset the error messages and input field styles
  //     resetErrors();

  //     // Validate the input fields
  //     if (isFieldEmpty(oldPassword, newPassword, passwordConfirm)) {
  //       showEmptyFieldError();
  //       return false;
  //     }

  //     if (!isPasswordsMatch(newPassword, passwordConfirm)) {
  //       showPasswordMismatchError();
  //       return false;
  //     }

  //     // If all validations pass, submit the form
  //     // this.submit();
  //   });

  //   // Function to reset error messages and input field styles
  //   function resetErrors() {
  //     $('.error').html('');
  //     $('#password_confirm').css('border-color', '');
  //     $('#new_password').css('border-color', '');
  //     $('#old_password').css('border-color', '');
  //   }

  //   // Function to check if any of the input fields are empty
  //   function isFieldEmpty(oldPassword, newPassword, passwordConfirm) {
  //     return oldPassword === '' || newPassword === '' || passwordConfirm === '';
  //   }

  //   // Function to show the error message for empty fields
  //   function showEmptyFieldError() {
  //     $('#password_confirm').css('border-color', 'red');
  //     $('#new_password').css('border-color', 'red');
  //     $('#old_password').css('border-color', 'red');
  //     $('.error').html('<p class="text-danger">Không được để trống</p>');
  //   }

  //   // Function to check if the new password and confirm password match
  //   function isPasswordsMatch(newPassword, passwordConfirm) {
  //     return newPassword === passwordConfirm;
  //   }

  //   // Function to show the error message for password mismatch
  //   function showPasswordMismatchError() {
  //     $('#password_confirm').css('border-color', 'red');
  //     $('#error_conf_password').html('<p class="text-danger">Mật khẩu nhập lại không trùng khớp</p>');
  //   }
  // });
</script>
<?php
include "footer.php";
?>