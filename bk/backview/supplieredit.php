<?php
include "header.php";
$page_title = "nhacungcap";
include "navside.php";

use Controller\SupplierController;

$supplier = new SupplierController;
if (isset($_POST['capnhat'])) {
  $idSupplier = $_GET['id'];
  $nameSupplier = $_POST['nameSupplier'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $description = $_POST['description'];
  if ($supplier->updateSupplier($idSupplier, $nameSupplier, $email, $address, $phone, $description)) {
    $_SESSION['success'] = "2";
    echo '<script>
        window.location.href = "suppliermanage.php";
      </script>';
  }
}
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $data = $supplier->getSupplier_detail($id)[0];
}
?>


<!-- Checkout Page Start -->
<div class="container-fluid pb-5">
  <div class="container pb-5">
    <h3>Cập nhật nhà cung cấp</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
      <div class="col-sm-12 col-xl-8">
        <div class=" rounded h-100 p-4">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="nameSupplier" name="nameSupplier" placeholder="Tên nhà cung cấp" value="<?php echo $data->nameSupplier ?>">
            <label for="nameSupplier">Tên nhà cung cấp</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $data->email ?>">
            <label for="email">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" value="<?php echo $data->address ?>">
            <label for="address">Địa chỉ</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="<?php echo $data->phone ?>">
            <label for="phone">Số điện thoại</label>
          </div>
          <div class="form-floating">
            <textarea class="form-control" placeholder="Thông tin nhà cung cấp" id="description" name="description" style="height: 150px;"><?php echo $data->description ?>
            </textarea>
            <label for="description">Thông tin mô tả</label>
          </div>

          <div class="text-center pt-5">
            <button class="btn btn-primary text-light" id="capnhat" name="capnhat">Cập nhật</button>
            <a href="supplier.php" class="btn btn-secondary text-light">Trở lại</a>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>
<!-- Checkout Page End -->
<?php
include "footer.php";
?>