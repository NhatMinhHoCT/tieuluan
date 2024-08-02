<?php
include "header.php";
$page_title = "kho";
include "navside.php";
require "../vendor/autoload.php";
use Controller\ImportController;
use Controller\StorageController;

$import = new ImportController;
$storage = new StorageController;

if (isset($_POST['taomoi'])) {
  $idProduct = $_POST['idProduct'];
  $quantity = $_POST['quantity'];
  $date_import = $_POST['date_import'];
  $note = $_POST['note'];
  if($import->insertImport($idProduct, $quantity, $date_import, $note)
  && $storage->modifyStorage($idProduct, $quantity, 1)){
    $_SESSION['success']=1;
    echo '<script>
    window.location.href = "storage.php";
    </script>';
  }
}
?>


<!-- Checkout Page Start -->
<div class="container-fluid pb-5">
  <div class="container pb-5">
    <h3>Nhập hàng</h3>
    <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
      <div class="col-sm-12 col-xl-8">
        <div class=" rounded h-100 p-4">

          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="idSupplier" name="idSupplier" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Casio</option>
              <option value="2">Skagen</option>
              <option value="3">Tissot</option>
              <option value="4">Halminton</option>
              <option value="5">Calvin Klein</option>
            </select>
            <label for="floatingSelect">Nhà cung cấp</label>
          </div>
          <div class="ajax_data">
            <div class="form-floating mb-3">
              <select class="form-select pb-2" id="idProduct" name="idProduct" aria-label="Floating label select example">
                <option selected disabled value="">Chọn sản phẩm</option>
              </select>
              <label for="floatingSelect">Sản phẩm</label>
            </div>
          </div>
          <div class="form-floating mb-3">
            <input type="number" min="0" step="1" class="form-control" id="quantity" name="quantity" placeholder="Số lượng nhập">
            <label for="price">Số lượng</label>
          </div>
          <div class="form-floating mb-3">
            <input type="date" class="form-control" id="date_import" name="date_import" placeholder="Ngày nhập">
            <label for="date_import">Ngày nhập</label>
          </div>
          <div class="form-floating">
            <textarea class="form-control" placeholder="Ghi chú" id="note" name="note" style="height: 150px;"></textarea>
            <label for="note">Ghi chú</label>
          </div>
          <div class="text-center pt-5">
            <button class="btn btn-primary text-light" id="taomoi" name="taomoi">Tạo mới</button>
            <a href="storage.php" class="btn btn-secondary text-light" role="button">Trở lại</a>

          </div>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#idSupplier").change(function() {
      var idSupplier = $(this).val();
      $.ajax({
        url: "storage_import_ajax.php",
        method: "POST",
        data: {
          idSupplier: idSupplier
        },
        success: function(data) {
          $('.ajax_data').html(data);
        }
      });
    });
  });
</script>
<!-- Checkout Page End -->
<?php
include "footer.php";
?>