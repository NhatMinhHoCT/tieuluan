<?php
include "header.php";
include "../controller/AccountController.php";
require_once "../vendor/autoload.php";

use Controller\AccountController;

$list = new AccountController();


if (isset($_POST['dangky'])) {
  echo '<script>
  console.log("dpne");
</script>';

  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  if ($list->checkExistRecord($username, $email)) {
    echo '<script>
  showToast("Thông báo", "Tài khoản hoặc email đã tồn tại", warning);
</script>';
  } else {
    if ($list->insertData($username, $password, $email)) {
      session_start();
      $_SESSION['notification'] = 1;
      echo '<script>
  window.location.href = "signin.php";
</script>';
    } else {
      echo '<script>
  showToast("Thông báo", "Đăng ký không thành công", error);
</script>';
    }
  }
}
?>
<div id="toast"></div>
<script src="../include/js/main.js"></script>

</body>

</html>