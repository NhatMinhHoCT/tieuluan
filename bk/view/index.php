<?php

include "header.php";
include "header_nav.php";

use Controller\ProductController;

if (isset($_SESSION['success']) && ($_SESSION['success'] == 1)) {
  echo "<script>
    setTimeout(function() {
      showToast('Thông báo', 'Đăng nhập thành công', 'success');
    }, 200);
  </script>";
  unset($_SESSION['success']);
}
?>

<!-- Hero Start -->
<div class="container-fluid pt-5">
  <div class="container py-5">
    <div class="row g-5 align-items-center">
      <div class="col-md-1 col-lg-1"></div>
      <div class="col-md-10 col-lg-10">
        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active rounded">
              <img src="../include/../include/img/banner1.webp" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
            </div>
            <div class="carousel-item rounded">
              <img src="../include/img/banner2.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Hero End -->

<!-- Fruits Shop Start-->
<div class="container-fluid fruite">
  <div class="container">
    <div class="tab-class text-center">
      <div class="row g-4">
        <div class="col-lg-4 text-start">
          <h1>Sản phẩm</h1>
        </div>
        <div class="col-lg-8 text-end">
          <ul class="nav nav-pills d-inline-flex text-center mb-5">
            <li class="nav-item">
              <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                <span class="text-dark" style="width: 130px;">Tất cả</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                <span class="text-dark" style="width: 130px;">Mới</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-5">
                <span class="text-dark" style="width: 130px;">Limited</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="tab-content">
        <div id="tab-1" class="tab-pane fade show p-0 active">
          <div class="row g-4">
            <div class="col-lg-12">
              <div class="row g-4">
                <?php
                $product = new ProductController;
                $limit = 8;
                $row = $product->getProduct(null, null, null, null, null, 0, $limit, 1);
                if ($row != null) {
                  foreach ($row as $data) {
                ?>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                      <a href="productdetail.php?id=<?php echo $data->idProduct ?>">
                        <div class="rounded position-relative fruite-item">
                          <div class="fruite-img">
                            <img src="../include/upload/<?php echo $data->image ?>" class="img-fluid w-50 rounded-top" alt="">
                          </div>
                          <?php echo $data->status == 2
                            ? '<div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>' : '' ?>

                          <div class="p-4 rounded-bottom text-center">
                            <h6><?php echo $data->name ?></h6>
                            <p><?php echo strtoupper($data->code) ?></p>
                            <div class="d-flex justify-content-center flex-lg-wrap">
                              <p class="text-dark fs-5 fw-bold mb-0"><?php echo number_format($data->price, 0, ',', '.') ?> đ</p>
                            </div>
                          </div>
                        </div>
                      </a>

                    </div>
                <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div id="tab-2" class="tab-pane fade show p-0">
          <div class="row g-4">
            <div class="col-lg-12">
              <div class="row g-4">
                <?php
                $row = $product->getProduct(null, null, null, null, null, 0, $limit, 2);
                if ($row != null) {
                  foreach ($row as $data) {
                ?>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                      <a href="productdetail.php?id=<?php echo $data->idProduct ?>">
                        <div class="rounded position-relative fruite-item">
                          <div class="fruite-img">
                            <img src="../include/upload/<?php echo $data->image ?>" class="img-fluid w-50 rounded-top" alt="">
                          </div>
                          <?php echo $data->status == 2
                            ? '<div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>' : '' ?>

                          <div class="p-4 rounded-bottom text-center">
                            <h6><?php echo $data->name ?></h6>
                            <p><?php echo strtoupper($data->code) ?></p>
                            <div class="d-flex justify-content-center flex-lg-wrap">
                              <p class="text-dark fs-5 fw-bold mb-0"><?php echo number_format($data->price, 0, ',', '.') ?> đ</p>
                            </div>
                          </div>
                        </div>
                      </a>

                    </div>
                <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
        <div id="tab-5" class="tab-pane fade show p-0">
          <div class="row g-4">
            <div class="col-lg-12">
              <div class="row g-4">
                <?php
                $row = $product->getProduct(null, null, null, null, null, 0, $limit, 3);
                if ($row != null) {
                  foreach ($row as $data) {
                ?>
                    <div class="col-md-6 col-lg-6 col-xl-3">
                      <a href="productdetail.php?id=<?php echo $data->idProduct ?>">
                        <div class="rounded position-relative fruite-item">
                          <div class="fruite-img">
                            <img src="../include/upload/<?php echo $data->image ?>" class="img-fluid w-50 rounded-top" alt="">
                          </div>
                          <?php echo $data->status == 2
                            ? '<div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>' : '' ?>

                          <div class="p-4 rounded-bottom text-center">
                            <h6><?php echo $data->name ?></h6>
                            <p><?php echo strtoupper($data->code) ?></p>
                            <div class="d-flex justify-content-center flex-lg-wrap">
                              <p class="text-dark fs-5 fw-bold mb-0"><?php echo number_format($data->price, 0, ',', '.') ?> đ</p>
                            </div>
                          </div>
                        </div>
                      </a>

                    </div>
                <?php
                  }
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid featurs py-5">
  <div class="container py-5">
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="featurs-item text-center rounded bg-light p-4">
          <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
            <i class="fas fa-car-side fa-3x text-white"></i>
          </div>
          <div class="featurs-content text-center">
            <h5>Miễn phí vận chuyển</h5>
            <p class="mb-0">Đơn hàng trên 2 triệu</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="featurs-item text-center rounded bg-light p-4">
          <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
            <i class="fas fa-user-shield fa-3x text-white"></i>
          </div>
          <div class="featurs-content text-center">
            <h5>Thanh toán bảo mật</h5>
            <p class="mb-0">Bảo mật thông tin khách hàng</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="featurs-item text-center rounded bg-light p-4">
          <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
            <i class="fas fa-exchange-alt fa-3x text-white"></i>
          </div>
          <div class="featurs-content text-center">
            <h5>30 ngày đổi trả</h5>
            <p class="mb-0">Hoàn tiền hoặc 1 đổi 1</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="featurs-item text-center rounded bg-light p-4">
          <div class="featurs-icon btn-square rounded-circle bg-primary mb-5 mx-auto">
            <i class="fa fa-phone-alt fa-3x text-white"></i>
          </div>
          <div class="featurs-content text-center">
            <h5>Chăm sóc khách hàng</h5>
            <p class="mb-0">Sẵn sàng phản hồi trong vòng 1h</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Product Start -->

<?php
include "footer.php";
?>