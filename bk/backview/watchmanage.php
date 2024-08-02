<?php
include "header.php";
$page_title = "sanpham";
include "navside.php";
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];

use Controller\ProductController;

$product = new ProductController;

if (isset($_SESSION['success']) && ($_SESSION['success'] == 1)) {
  echo '<script>
  setTimeout(function () {
  showToast("Thành công", "Thêm sản phẩm mới thành công", "success")
  },1000)
  </script>';
  unset($_SESSION['success']);
}
if (isset($_SESSION['success']) && ($_SESSION['success'] == 2)) {
  echo '<script>
  setTimeout(function () {
  showToast("Thành công", "Cập nhật sản phẩm thành công", "success")
  },1000)
  </script>';
  unset($_SESSION['success']);
}
?>

<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-12">
      <div class="rounded h-100 p-4">
        <a href="watchmanageadd.php" class="btn btn-outline-primary mb-3" name="themmoi" id="themmoi">Thêm mới</a>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">STT</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Thương hiệu</th>
                <th scope="col">Giá bán</th>
                <th scope="col">Ghi chú</th>
                <th scope="col">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $limit = 5;
              $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
              $start = ($currentPage - 1) * $limit;
              $totalItems = $product->countProduct(null, null, null, null, null);
              $totalPages = ceil($totalItems[0]['count'] / $limit);
              $row = $product->getProduct(null, null, null, null, null, $start, $limit,2);
              $i = ($currentPage - 1) * $limit + 1;
              foreach ($row as $data) {
                switch ($data->idSupplier) {
                  case '1':
                    $brand = "Casio";
                    break;
                  case '2':
                    $brand = "Skagen";
                    break;
                  case '3':
                    $brand = "Tissot";
                    break;
                  case '4':
                    $brand = "Halminton";
                    break;
                  case '5':
                    $brand = "Calvin Klein";
                    break;
                  default:
                    # code...
                    break;
                }
              ?>
                <tr>
                  <td class="py-5"><?php echo $i ?></td>
                  <th scope="row">
                    <div class="d-flex align-items-center mt-2">
                      <img src="../include/upload/<?php echo $data->image ?>" class="img-fluid" style="width: 75px; height: 90px;" alt="">
                    </div>
                  </th>
                  <td class="py-5"><?php echo $data->name ?></td>
                  <td class="py-5"><?php echo $brand ?></td>
                  <td class="py-5"><?php echo number_format($data->price, 0, '', ',') ?> đ</td>
                  <td>
                    <?php echo ($data->status == 1) ? '<span class="badge bg-secondary mt-5">Limited</span><br />' : '' ?>

                  </td>
                  <td class="py-5">
                    <a href="watchdetail.php?id=<?php echo $data->idProduct ?>" class="btn btn-md bg-success border" title="Chi tiết">
                      <i class="fa fa-pen text-light "></i>
                    </a>
                    <a href="watchdetail.php?deleteid='<?php echo $data->idProduct ?>" class="btn btn-md bg-danger border" title="Xóa">
                      <i class="fa fa-trash text-light"></i>
                    </a>
                  </td>
                </tr>
              <?php
                $i++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

echo '<div class="pagination d-flex justify-content-center mt-5">';

if ($currentPage > 1) {
  $prevPage = $currentPage - 1;
  echo '<a href="?page=' . $prevPage . '" class="rounded">&laquo;</a>';
}

for ($i = 1; $i <= $totalPages; $i++) {
  $activeClass = ($i == $currentPage) ? 'active' : '';
  echo '<a href="?page=' . $i . '" class="rounded ' . $activeClass . '">' . $i . '</a>';
}


if ($currentPage < $totalPages) {
  $nextPage = $currentPage + 1;
  echo '<a href="?page=' . $nextPage . '" class="rounded">&raquo;</a>';
}

echo '</div>';
?>

<?php
include "footer.php"
?>