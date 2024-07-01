<?php

use Controller\ProductController;

require "../vendor/autoload.php";
include "header.php";
include "header_nav.php";
$product = new ProductController;
$idProduct = isset($_GET['id']) ? $_GET['id'] : '';
$data = $product->getProduct_detail($idProduct);
?>
<!-- Single Product Start -->

<div class="container-fluid py-5">
  <div class="container py-5">
    <div class="pb-5">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <?php
        switch ($data->kind) {
          case '1':
            echo '<li class="breadcrumb-item "><a href="product_manwatch.php">Đồng hồ nam</a></li>';
            break;
          case '2':
            echo
            '<li class="breadcrumb-item "><a href="product_womanwatch.php">Đồng hồ nữ</a></li>';
            break;
          case '3':
            echo
            '<li class="breadcrumb-item "><a href="product_couplewatch.php">Đồng hồ cặp đôi</a></li>';
            break;
          default:
            # code...
            break;
        }
        ?>
        <li class="breadcrumb-item active">Sản phẩm số <?php echo $data->idProduct ?> </li>
      </ol>
    </div>
    <div class="row g-4 mb-5 justify-content-center">
      <div class="col-lg-8 col-xl-9">
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="border rounded">
              <a href="#">
                <img src="../include/upload/<?php echo $data->image ?>" class="img-fluid rounded" alt="Image">
              </a>
            </div>
          </div>
          <div class="col-lg-6">
            <h4 class="fw-bold mb-3"><?php echo $data->name ?></h4>
            <?php
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
            <p class="mb-3">Thương hiệu: <?php echo $brand ?></p>
            <p class="mb-3">Mã sản phẩm: <?php echo $data->code ?></p>
            <p class="fw-bold mb-3 text-danger" value="<?php echo $data->price ?>"><?php echo number_format($data->price, 0, ',', '.') ?> vnđ</p>
            <p class="mb-4">Mẫu Citizen NJ0154-80H phiên bản mặt kính chất liệu kính Sapphire với kích thước nam tính 40mm, kết hợp cùng mẫu dây đeo kim loại dây vàng demi phong cách thời trang sang trọng.</p>
            <div class="input-group quantity mb-5" style="width: 100px;">
              <div class="input-group-btn">
                <button class="btn btn-sm btn-minus rounded-circle bg-light border" onclick="decrementValue()">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
              <input type="text" class="form-control form-control-sm text-center border-0" id="quantityInput" value="1">
              <div class="input-group-btn">
                <button class="btn btn-sm btn-plus rounded-circle bg-light border" onclick="incrementValue()">
                  <i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <input type="hidden" id="productPrice" value="<?php echo $data->price ?>">
            <input type="hidden" id="productId" value="<?php echo $data->idProduct ?>">
            <input type="hidden" id="productImage" value="<?php echo $data->image ?>">
            <button id="addToCartBtn" class="btn border border-primary rounded-pill px-4 py-2 mb-4 text-primary"><i class="fa fa-shopping-bag me-2"></i>Thêm vào giỏ hàng</button>
          </div>
          <div class="col-lg-12">
            <nav>
              <div class="nav nav-tabs mb-3">
                <button class="nav-link active border-white border-bottom-0" type="button" role="tab" id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about" aria-controls="nav-about" aria-selected="true">Thông tin sản phẩm</button>
                <button class="nav-link border-white border-bottom-0" type="button" role="tab" id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission" aria-controls="nav-mission" aria-selected="false">Chế độ bảo hành</button>
              </div>
            </nav>
            <div class="tab-content mb-5">
              <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                <div class="px-2">
                  <div class="row g-4">
                    <div class="col-6">
                      <table class="table table-borderless">
                        <tr>
                          <th>Loại:</th>
                          <td><?php
                              switch ($data->kind) {
                                case '1':
                                  $kind_data = "Nam";
                                  break;
                                case '2':
                                  $kind_data = "Nữ";
                                  break;
                                case '3':
                                  $kind_data = "Cặp đôi";
                                  break;
                                default:
                                  break;
                              }
                              echo $kind_data; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Kiểu máy:</th>
                          <td>
                            <?php
                            switch ($data->machinetype) {
                              case '1':
                                $machineType_data = "Máy cơ tự động";
                                break;
                              case '2':
                                $machineType_data = "Máy pin điện tử";
                                break;
                              case '3':
                                $machineType_data = "Năng lượng ánh sáng";
                                break;
                              default:
                                break;
                            }
                            echo $machineType_data;
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Màu sắc:</th>
                          <td><?php
                              switch ($data->color) {
                                case '1':
                                  $color_data = "Trắng";
                                  break;
                                case '2':
                                  $color_data = "Đen";
                                  break;
                                case '3':
                                  $color_data = "Vàng";
                                  break;
                                case '4':
                                  $color_data = "Nâu";
                                  break;
                                case '5':
                                  $color_data = "Xám";
                                  break;
                                default:
                                  break;
                              }
                              echo $color_data; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Xuất xứ:</th>
                          <td><?php
                              switch ($data->origin) {
                                case '1':
                                  $origin_data = "Nhật Bản";
                                  break;
                                case '2':
                                  $origin_data = "Thụy Sĩ";
                                  break;
                                case '3':
                                  $origin_data = "Mỹ";
                                  break;
                                case '4':
                                  $origin_data = "Đan Mạch";
                                  break;
                                default:
                                  break;
                              }
                              echo $origin_data; ?>
                          </td>
                        </tr>

                      </table>
                    </div>
                    <div class="col-6">
                      <table class="table table-borderless">
                        <tr>
                          <th>Đường kính:</th>
                          <td><?php
                              switch ($data->diameter) {
                                case '1':
                                  $diameter_data = "Dưới 20mm";
                                  break;
                                case '2':
                                  $diameter_data = "20-30mm";
                                  break;
                                case '3':
                                  $diameter_data = "30-40mm";
                                  break;
                                case '4':
                                  $diameter_data = "Trên 40mm";
                                  break;
                                default:
                                  break;
                              }
                              echo $diameter_data; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Chất liệu dây:</th>
                          <td><?php
                              switch ($data->watchchain) {
                                case '1':
                                  $watchchain_data = "Dây kim loại";
                                  break;
                                case '2':
                                  $watchchain_data = "Nhựa tổng hợp";
                                  break;
                                case '3':
                                  $watchchain_data = "Dây da";
                                  break;
                                case '4':
                                  $watchchain_data = "Vải";
                                  break;
                                case '5':
                                  $watchchain_data = "Chất liệu khác";
                                  break;
                                default:
                                  break;
                              }
                              echo $watchchain_data; ?>

                          </td>
                        </tr>
                        <tr>
                          <th>Bảo hành:</th>
                          <td><?php
                              switch ($data->guarantee) {
                                case '1':
                                  $guarantee_data = "1 năm";
                                  break;
                                case '2':
                                  $guarantee_data = "2 năm";
                                  break;
                                case '3':
                                  $guarantee_data = "3 năm";
                                  break;
                                case '4':
                                  $guarantee_data = "5 năm";
                                  break;
                                default:
                                  break;
                              }
                              echo $guarantee_data; ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                <p>
                  Theo chính sách bảo hành của các hãng đồng hồ, tất cả các đồng hồ chính hãng bán ra đều kèm theo 01 thẻ/ sổ/ giấy bảo hành Quốc tế có giá trị bảo hành theo thời gian qui định của từng hãng đồng hồ khác nhau.
                  </br>Mỗi thẻ/ sổ/ giấy bảo hành chỉ được phát hành kèm theo mỗi chiếc đồng hồ bán ra một lần duy nhất và không cấp lại dưới bất kỳ hình thức nào
                </p>
                <h6>
                  I. CHÍNH SÁCH BẢO HÀNH QUỐC TẾ
                </h6>
                <p>
                  - Bảo hành chỉ có giá trị khi đồng hồ có thẻ/ sổ/ giấy bảo hành chính thức đi kèm. Thẻ/ sổ/ giấy bảo hành phải được ghi đầy đủ và chính xác các thông tin như: Mã số đồng hồ, mã đáy đồng hồ (nếu có), địa chỉ bán, ngày mua hàng, ....Thẻ/ sổ/ giấy bảo hành phải được đóng dấu của Đại lý ủy quyền chính thức hoặc Cửa hàng bán ra.</br>
                  - Thời gian bảo hành của đồng hồ được tính kể từ ngày mua ghi trên thẻ/ sổ/ giấy bảo hành và không được gia hạn sau khi hết thời hạn bảo hành. Cụ thể như sau:</br>
                  + Thời hạn bảo hành theo tiêu chuẩn Quốc tế của các hãng Đồng hồ Nhật Bản là 1 năm (riêng đối với đồng hồ Orient Star là 2 năm). Bao gồm các thương hiệu: Seiko, Citizen, Orient.</br>
                  + Thời hạn bảo hành theo tiêu chuẩn Quốc tế của các hãng Đồng hồ Thụy Sỹ là 2 năm (riêng đối với dòng máy Chronometer của Tissot, Mido là 3 năm). Bao gồm các thương hiệu: Longines, Mido, Tissot, Calvin Klein, Frederique Constant, Certina, Claude Bernard, Rotary, Charriol, Candino.</br>
                  + Các thương hiệu khác có chế độ bảo hành riêng như sau: 2 năm đối với thương hiệu Daniel Wellington, Freelook, Olympia Star, Olym Pianus và bảo hành máy trọn đời đối với thương hiệu Skagen.</br>
                  - Chỉ bảo hành miễn phí cho trường hợp hư hỏng về máy và các linh kiện bên trong của đồng hồ khi được xác định là do lỗi của nhà sản xuất.</br>
                  - Chỉ bảo hành, sửa chữa hoặc thay thế mới cho các linh kiện bên trong đồng hồ. Không thay thế hoặc đổi bằng 1 chiếc đồng hồ khác.
                </p>
              </div>
              <div class="tab-pane" id="nav-vision" role="tabpanel">
                <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                  amet diam et eos labore. 3</p>
                <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore.
                  Clita erat ipsum et lorem et sit</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <h3 class="fw-bold mb-0">Sản phẩm liên quan</3>
      <div class="tab-content">
        <div id="tab-1" class="tab-pane fade show p-0 active">
          <div class="row g-4 justify-content-center">
            <div class="row g-4 col-10">
              <div class="col-md-6 col-lg-6 col-xl-3">
                <a href="productdetail.php">
                  <div class="rounded position-relative fruite-item">
                    <div class="fruite-img">
                      <img src="../include/../include/img/donghonam1.jpg" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                    <div class="p-4 rounded-bottom text-center">
                      <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                      <p>H77785733</p>
                      <div class="d-flex justify-content-center flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-3">
                <a href="productdetail.php">
                  <div class="rounded position-relative fruite-item">
                    <div class="fruite-img">
                      <img src="../include/img/donghonam2.jpg" class="img-fluid w-100 rounded-top" alt="">
                    </div>
                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                    <div class="p-4 rounded-bottom text-center">
                      <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                      <p>H77785733</p>
                      <div class="d-flex justify-content-center flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                      </div>
                    </div>
                  </div>
                </a>

              </div>
              <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded position-relative fruite-item">
                  <div class="fruite-img">
                    <img src="../include/img/donghonam3.jpg" class="img-fluid w-100 rounded-top" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                  <div class="p-4 rounded-bottom text-center">
                    <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                    <p>H77785733</p>
                    <div class="d-flex justify-content-center flex-lg-wrap">
                      <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded position-relative fruite-item">
                  <div class="fruite-img">
                    <img src="../include/img/donghonam4.jpg" class="img-fluid w-100 rounded-top" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                  <div class="p-4 rounded-bottom text-center">
                    <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                    <p>H77785733</p>
                    <div class="d-flex justify-content-center flex-lg-wrap">
                      <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded position-relative fruite-item">
                  <div class="fruite-img">
                    <img src="../include/img/donghonam5.jpg" class="img-fluid w-100 rounded-top" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                  <div class="p-4 rounded-bottom text-center">
                    <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                    <p>H77785733</p>
                    <div class="d-flex justify-content-center flex-lg-wrap">
                      <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded position-relative fruite-item">
                  <div class="fruite-img">
                    <img src="../include/img/donghonam6.jpg" class="img-fluid w-100 rounded-top" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                  <div class="p-4 rounded-bottom text-center">
                    <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                    <p>H77785733</p>
                    <div class="d-flex justify-content-center flex-lg-wrap">
                      <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded position-relative fruite-item">
                  <div class="fruite-img">
                    <img src="../include/img/donghonam7.jpg" class="img-fluid w-100 rounded-top" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                  <div class="p-4 rounded-bottom text-center">
                    <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                    <p>H77785733</p>
                    <div class="d-flex justify-content-center flex-lg-wrap">
                      <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="rounded position-relative fruite-item">
                  <div class="fruite-img">
                    <img src="../include/img/donghonam8.jpg" class="img-fluid w-100 rounded-top" alt="">
                  </div>
                  <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                  <div class="p-4 rounded-bottom text-center">
                    <h6>ĐỒNG HỒ NAM HAMILTON VENTURA</h6>
                    <p>H77785733</p>
                    <div class="d-flex justify-content-center flex-lg-wrap">
                      <p class="text-dark fs-5 fw-bold mb-0">600000 vnd</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
  </div>

  <script>
    function incrementValue() {
      var input = document.getElementById('quantityInput');
      var value = parseInt(input.value);
      if (!isNaN(value)) {
        input.value = value + 1;
      }
    }

    function decrementValue() {
      var input = document.getElementById('quantityInput');
      var value = parseInt(input.value);
      if (!isNaN(value) && value > 1) {
        input.value = value - 1;
      }
    }

    function addToCart() {
      // Get the product details
      const productName = document.querySelector('h4.fw-bold').textContent;
      const productPrice = document.getElementById('productPrice').value;
      const productQuantity = document.getElementById('quantityInput').value;
      const productId = document.getElementById('productId').value;
      const productImage = document.getElementById('productImage').value;

      // Create a form element
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '../controller/CartController.php';

      // Create input fields for product data
      const nameInput = document.createElement('input');
      nameInput.type = 'hidden';
      nameInput.name = 'name';
      nameInput.value = productName;
      form.appendChild(nameInput);

      const priceInput = document.createElement('input');
      priceInput.type = 'hidden';
      priceInput.name = 'price';
      priceInput.value = productPrice;
      form.appendChild(priceInput);

      const quantityInput = document.createElement('input');
      quantityInput.type = 'hidden';
      quantityInput.name = 'quantity';
      quantityInput.value = productQuantity;
      form.appendChild(quantityInput);

      const idInput = document.createElement('input');
      idInput.type = 'hidden';
      idInput.name = 'idInput';
      idInput.value = productId;
      form.appendChild(idInput);

      const imageInput = document.createElement('input');
      imageInput.type = 'hidden';
      imageInput.name = 'imageInput';
      imageInput.value = productImage;
      form.appendChild(imageInput);

      // Submit the form
      document.body.appendChild(form);
      form.submit();
    }

    // Add an event listener to the "Thêm vào giỏ hàng" button
    document.getElementById('addToCartBtn').addEventListener('click', addToCart);
  </script>
  <!-- Single Product End -->
  <?php
  include "footer.php";

  ?>