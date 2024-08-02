<?php
include "header.php";
include "../controller/AccountController.php";
require_once "../vendor/autoload.php";

use Controller\AccountController;

$list = new AccountController();


?>

<!-- Sign up Start -->
<div class="container-fluid bg-primary">
  <div class="row h-50 align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
      <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <a href="index.html" class="">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>EWatch</h3>
          </a>
          <h3 class="text-primary">Đăng ký</h3>
        </div>
        <form method="POST" action="process_signup.php">
          <div class="mb-3">
            <label for="username" class="form-label ">Tên tài khoản</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>" required>
            <p class="text-danger mt-2"></p>
          </div>
          <div sclass="mb-3">
            <label for="email" class="form-label ">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
            <p class="text-danger mt-2"></p>
          </div>
          <div class="mb-4">
            <label for="password" class="form-label ">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password">
            <p class="text-danger mt-2"></p>
          </div>
          <div class="  mb-4">
            <label for="repassword" class="form-label ">Nhập lại mật khẩu</label>
            <input type="password" class="form-control" id="repassword" name="repassword">
            <p class="text-danger mt-2"></p>
          </div>
          <button type="submit" name="dangky" class="btn btn-primary text-light py-3 w-100 mb-4">Đăng ký</button>
          <p class="text-center  mb-0">Đã có tài khoản? <a href="signin.php" class=" fw-bold fs-5 ">Đăng nhập</a></p>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Sign In End -->
</div>

<script src="../include/js/main.js"></script>

<script>
  $('form').on('submit', function(e) {
    e.preventDefault();
    let username = $("#username").val();
    let email = $("#email").val();
    let password = $("#password").val();
    let repassword = $("#repassword").val();
    let isValid = true;

    // Reset error messages
    $('#username').next().text('');
    $('#email').next().text('');
    $('#password').next().text('');
    $('#repassword').next().text('');

    if (password != repassword) {
      $('#password').next().text('Mật khẩu nhập lại không trùng khớp');
      isValid = false;
    }
    if (username == '') {
      $('#username').next().text('Vui lòng nhập tên tài khoản');
      isValid = false;
    }
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email == '') {
      $('#email').next().text('Vui lòng nhập email');
      isValid = false;
    } else if (!emailRegex.test(email)) {
      $('#email').next().text('Email không hợp lệ');
      isValid = false;
    }

    if (password == '') {
      $('#password').next().text('Vui lòng nhập mật khẩu');
      isValid = false;
    }

    if (repassword == '') {
      $('#repassword').next().text('Vui lòng nhập lại mật khẩu');
      isValid = false;
    }

    if (isValid) {
      this.submit();
    }
  });
</script>
</body>

</html>