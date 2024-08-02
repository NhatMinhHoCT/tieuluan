<?php
include "header.php";
$page_title = "taikhoan";
include "navside.php";

use Controller\AccountController;

$account = new AccountController;

?>
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
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
    <div class="col-12">
      <div class="rounded h-100 p-4">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">SDT</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
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
                $row = $account->getAccount($search, $start, $limit);
                $totalItems = $account->countAccount($search);
              } else {
                $row = $account->getAccount(null, $start, $limit);
                $totalItems = $account->countAccount(null);
              }
              $totalPages = ceil($totalItems / $limit);
              $i = ($currentPage - 1) * $limit + 1;
              if ($row != null) {
                foreach ($row as $data) {
              ?>
                  <tr>
                    <td class="py-5"><?php echo $i ?></td>
                    <td class="py-5"><?php echo $data->username ?></td>
                    <td class="py-5"><?php echo $data->phone ?></td>
                    <td class="py-5"><?php echo $data->email ?></td>
                    <td class="py-5"><?php echo $data->address ?></td>
                    <td class="py-5">
                      <a href="" class="btn btn-md bg-success border" title="Chi tiết">
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
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
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

<!-- Table End -->


<?php
include "footer.php"
?>