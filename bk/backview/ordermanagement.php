<?php
include "header.php";
$page_title = "donhang";
include "navside.php";

use Controller\OrderController;

$orders = new OrderController();
?>



<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-12">
      <div class="rounded h-100 p-4">
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
                <th scope="col">Mã khách hàng</th>
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
                $row = $orders->getOrderAll(null, $search, $start, $limit);
                $totalItems = $orders->countOrderAll(null, $search);
              } else {
                $row = $orders->getOrderAll(null, null, $start, $limit);
                $totalItems = $orders->countOrderAll(null, null);
              }

              $totalPages = ceil($totalItems / $limit);
              if ($row != null) {
                foreach ($row as $data) {
              ?>
                  <tr>
                    <td><?php echo date_format(date_create($data->order_date), 'd/m/Y') ?></td>
                    <td><?php echo $data->order_code ?></td>
                    <td>KH-<?php echo $data->customer_id ?></td>
                    <td><?php echo $data->total_amount ?></td>
                    <td><?php echo $data->payment_method ?></td>
                    <td>
                      <?php
                      switch ($data->state) {
                        case '1':
                          $stage_text = "Đang xử lý";
                          $badge = "badge bg-primary";
                          break;
                        case '2':
                          $stage_text = "Đang giao hàng";
                          $badge = "badge bg-success";
                          break;
                        case '3':
                          $stage_text = "Đã giao hàng";
                          $badge = "badge bg-dark";
                          break;
                        default:
                          # code...
                          break;
                      }; ?>
                      <p class="<?php echo $badge ;?>"><?php echo $stage_text ?></p>
                    </td>
                    <td>
                      <a href="order_detail.php?id=<?php echo $data->idOrder ?>" class="btn btn-md bg-success border" title="Chi tiết">
                        <i class="fa fa-pen text-light "></i>
                      </a>
                      <a href="" class="btn btn-md bg-danger border" title="Xóa">
                        <i class="fa fa-trash text-light"></i>
                      </a>
                    </td>
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
    </div>
  </div>
</div>

<!-- Table End -->


<?php
include "footer.php"
?>