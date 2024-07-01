<?php
include "header.php";
$page_title = "nhacungcap";
include "navside.php";

use Controller\SupplierController;

if (isset($_SESSION['success']) && ($_SESSION['success'] == 1)) {
  echo '<script>
  setTimeout(function () {
  showToast("Thành công", "Thêm nhà cung cấp mới thành công", "success")
  },1000)
  </script>';
  unset($_SESSION['success']);
}
if (isset($_SESSION['success']) && ($_SESSION['success'] == 2)) {
  echo '<script>
  setTimeout(function () {
  showToast("Thành công", "Cập nhật thông tin nhà cung cấp thành công", "success")
  },1000)
  </script>';
  unset($_SESSION['success']);
}
$supplier = new SupplierController;
?>



<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">

    <div class="col-12">
      <div class="rounded h-100 p-4">
        <a href="supplieradd.php" class="btn btn-outline-primary mb-3" name="themmoi" id="themmoi">Thêm mới</a>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">STT</th>
                <th scope="col">Nhà cung cấp</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $limit = 5;
              $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
              $start = ($currentPage - 1) * $limit;
              $totalItems = $supplier->countSupplier();
              $totalPages = ceil($totalItems[0]['count'] / $limit);
              $row = $supplier->getSupplier($start, $limit);
              $i = 1;
              foreach ($row as $data) {
              ?>
                <tr>
                  <td class="py-3"><?php echo $i ?></td>
                  <td class="py-3"><?php echo $data->nameSupplier ?></td>
                  <td class="py-3"><?php echo $data->address ?></td>
                  <td class="py-3"><?php echo $data->phone ?></td>
                  <td class="py-3"><?php echo $data->email ?></td>
                  <td class="py-3">
                    <a href="supplieredit.php?id=<?php echo $data->idSupplier ?>" class="btn btn-md bg-success border" title="Chi tiết">
                      <i class="fa fa-pen text-light "></i>
                    </a>
                    <a href="" class="btn btn-md bg-danger border" title="Xóa">
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