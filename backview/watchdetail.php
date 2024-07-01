<?php
include "header.php";
$page_title = "sanpham";
include "navside.php";
require "../vendor/autoload.php";

use Controller\ProductController;

$product = new ProductController;
$data = $product->getProduct_detail(isset($_GET['id']) ? $_GET['id'] : $_POST['idProduct']);
if (isset($_POST['capnhat'])) {
  $idProduct = $_POST['idProduct'];
  $name = $_POST['name'];
  $idSupplier = $_POST['idSupplier'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $kind = $_POST['kind'];
  $machineType = $_POST['machineType'];
  $color = $_POST['color'];
  $origin = $_POST['origin'];
  $diameter = $_POST['diameter'];
  $watchChain = $_POST['watchChain'];
  $guarantee = $_POST['guarantee'];
  if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
    $imageName = $_FILES['image']['name'];
    $imageSize = $_FILES['image']['size'];
    $tmpName = $_FILES['image']['tmp_name'];
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));
    if (!in_array($imageExtension, $validImageExtension)) {
      echo '<script>
      alert("Định dạng ảnh không đúng");
      history.go(-1);
    </script>';
    } elseif ($imageSize > 1000000) {
      echo '<script>
      alert("Kích thước ảnh quá lớn");
      history.go(-1);
    </script>';
    } else {
      $image = basename($imageName);
      move_uploaded_file($tmpName, '../include/upload/' . $image);
    }
  } else {
    $image = $data->image;
  }
  if ($update = $product->updateProduct($idProduct, $name, $status, $idSupplier, $image, $price, $description, $kind, $machineType, $color, $origin, $diameter, $watchChain, $guarantee)) {
    $_SESSION['success'] = "2";
    echo '<script>
        window.location.href = "watchmanage.php";
      </script>';
  }
}

?>


<!-- Checkout Page Start -->
<div class="container-fluid pb-5">
  <div class="container pb-5 row">
    <h3>Cập nhật sản phẩm</h3>
    <div class="col-sm-12 col-xl-8">
      <form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class=" rounded h-100 p-4">
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="name" name="name" placeholder="Tên sản phẩm" value="<?php echo $data->name ?>">
            <label for="name">Tên sản phẩm</label>
            <input type="hidden" name="idProduct" value="<?php echo $data->idProduct ?>">
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="idSupplier" name="idSupplier" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Casio</option>
              <option value="2">Skagen</option>
              <option value="3">Tissot</option>
              <option value="4">Halminton</option>
              <option value="5">Calvin Klein</option>
            </select>
            <label for="floatingSelect">Thương hiệu</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="status" name="status" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Normal</option>
              <option value="2">Limited</option>
            </select>
            <label for="floatingSelect">Trạng thái</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="kind" name="kind" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Nam</option>
              <option value="2">Nữ</option>
              <option value="3">Cặp đôi</option>
            </select>
            <label for="kind">Loại sản phẩm</label>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Chọn hình ảnh</label>
            <input class="form-control" type="file" id="image" name="image">
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="price" name="price" placeholder="Giá sản phẩm" value="<?php echo $data->price ?>">
            <label for="price">Giá sản phẩm</label>
          </div>
          <div class="form-floating">
            <textarea class="form-control" placeholder="Mô tả sản phẩm" id="description" name="description" style="height: 150px;"><?php echo $data->description ?>
            </textarea>
            <label for="description">Thông tin mô tả</label>
          </div>
          <div class="form-floating my-3">
            <select class="form-select pb-2" id="machineType" name="machineType" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Máy cơ tự động</option>
              <option value="2">Máy pin điện tử</option>
              <option value="3">Năng lượng ánh sáng</option>
            </select>
            <label for="machineType">Kiểu máy</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="color" name="color" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Trắng</option>
              <option value="2">Đen</option>
              <option value="3">Vàng</option>
              <option value="4">Nâu</option>
              <option value="4">Xám</option>
            </select>
            <label for="color">Màu sắc</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="origin" name="origin" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Nhật Bản</option>
              <option value="2">Thụy Sĩ</option>
              <option value="3">Mỹ</option>
              <option value="4">Đan Mạch</option>
            </select>
            <label for="origin">Xuất xứ</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="diameter" name="diameter" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Dưới 20mm</option>
              <option value="2">20-30mm</option>
              <option value="3">30-40mm</option>
              <option value="4">Trên 40mm</option>
            </select>
            <label for="diameter">Đường kính</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="watchChain" name="watchChain" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">Dây kim loại</option>
              <option value="2">Nhựa tổng hợp</option>
              <option value="3">Dây da</option>
              <option value="4">Vải</option>
              <option value="5">Chất liệu khác</option>
            </select>
            <label for="watchChain">Loại dây</label>
          </div>
          <div class="form-floating mb-3">
            <select class="form-select pb-2" id="guarantee" name="guarantee" aria-label="Floating label select example">
              <option selected disabled></option>
              <option value="1">1 năm</option>
              <option value="2">2 năm</option>
              <option value="3">3 năm</option>
              <option value="4">5 năm</option>
            </select>
            <label for="guarantee">Bảo hành</label>
          </div>
          <div class="text-center pt-5">
            <button class="btn btn-primary text-light" type="submit" id="capnhat" name="capnhat">Cập nhật</button>
            <a href="<?php echo $_SESSION['previous_url'] ?>" class="btn btn-secondary text-light">Trở lại</a>
          </div>
        </div>
      </form>
    </div>
    <div class="col-sm-12 col-xl-4">
      <div>
        <img src="../include/upload/<?php echo $data->image ?>" class="img-fluid w-100 rounded-top" alt="">
        <input type="hidden">
      </div>
    </div>
  </div>
</div>
<?php
// Assuming you have the $data->idSupplier value available
$kind = $data->kind;
$supplierId = $data->idSupplier;
$status = $data->status;
$machineType = $data->machinetype;
$color = $data->color;
$origin = $data->origin;
$diameter = $data->diameter;
$watchChain = $data->watchchain;
$guarantee = $data->guarantee;

?>

<script>
  $(document).ready(function() {
    let supplierId = <?php echo $supplierId; ?>;
    $('#idSupplier option').each(function() {
      if ($(this).val() == supplierId) {
        $(this).prop('selected', true);
      }
    });
    let kind = <?php echo $kind; ?>;
    $('#kind option').each(function() {
      if ($(this).val() == kind) {
        $(this).prop('selected', true);
      }
    });
    let status = <?php echo $status; ?>;
    $('#status option').each(function() {
      if ($(this).val() == status) {
        $(this).prop('selected', true);
      }
    });
    let machineType = <?php echo $machineType; ?>;
    $('#machineType option').each(function() {
      if ($(this).val() == machineType) {
        $(this).prop('selected', true);
      }
    });
    let color = <?php echo $color; ?>;
    $('#color option').each(function() {
      if ($(this).val() == color) {
        $(this).prop('selected', true);
      }
    });
    let origin = <?php echo $origin; ?>;
    $('#origin option').each(function() {
      if ($(this).val() == origin) {
        $(this).prop('selected', true);
      }
    });
    let diameter = <?php echo $diameter; ?>;
    $('#diameter option').each(function() {
      if ($(this).val() == diameter) {
        $(this).prop('selected', true);
      }
    });
    let watchChain = <?php echo $watchChain; ?>;
    $('#watchChain option').each(function() {
      if ($(this).val() == watchChain) {
        $(this).prop('selected', true);
      }
    });
    let guarantee = <?php echo $guarantee; ?>;
    $('#guarantee option').each(function() {
      if ($(this).val() == guarantee) {
        $(this).prop('selected', true);
      }
    });
  });
</script>
<!-- Checkout Page End -->
<?php
include "footer.php";
?>