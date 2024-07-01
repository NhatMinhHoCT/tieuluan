 <?php
  include "header.php";
  include "header_nav.php";

  use Controller\ProductController;
  ?>
 < <div class="container-fluid py-5">
   <div class="container py-5">
     <div class="pb-5">
       <ol class="breadcrumb mb-0">
         <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
         <li class="breadcrumb-item"><a href="product_couplewatch.php">Đồng hồ Cặp đôi</a></li>
       </ol>
     </div>
     <div class="row g-4">
       <div class="col-lg-12">
         <div class="row g-4">
           <div class="col-xl-3">
             <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
               <label for="fruits">Lọc:</label>
               <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3" form="fruitform">
                 <option value="volvo">Tất cả</option>
                 <option value="saab">Nổi bật</option>
                 <option value="opel">Bestseller</option>
                 <option value="audi">Limited</option>
               </select>
             </div>
           </div>
           <div class="col-6"></div>
           <div class="col-xl-3 pb-5">
             <div class="input-group w-100 mx-auto d-flex">
               <input type="search" class="form-control p-3" placeholder="Tìm kiếm" aria-describedby="search-icon-1">
               <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i></button>
             </div>
           </div>
         </div>
         <div class="row g-4">
           <div class="col-lg-9">
             <div class="row g-4">
               <?php
                $product = new ProductController;
                $limit = 8;
                $kind = 3;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($currentPage - 1) * $limit;
                $totalItems = $product->countProduct($search = null, $kind);
                $totalPages = ceil($totalItems[0]['count'] / $limit);
                $row = $product->getProduct($search, $kind, $start, $limit);
                foreach ($row as $data) {
                ?>
                 <div class="col-md-6 col-lg-6 col-xl-3 fruite-item">
                   <a href="productdetail.php?id=<?php echo $data->idProduct ?>" class="text-decoration-none">
                     <div class="rounded position-relative fruite-item">
                       <div class="fruite-img">
                         <img src="../include/upload/<?php echo $data->image ?>" class="img-fluid w-100 rounded-top" alt="">
                       </div>
                       <?php
                        if ($data->status == 1) {
                        ?>
                         <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Limited</div>
                       <?php
                        }
                        ?>

                       <div class="p-4 rounded-bottom text-center">
                         <h6><?php echo $data->name ?></h6>
                         <p><?php echo $data->code ?></p>
                         <div class="d-flex justify-content-center flex-lg-wrap">
                           <p class="text-dark fs-5 fw-bold mb-0"><?php echo number_format($data->price, 0, ',', '.') ?> vnd</p>
                         </div>
                       </div>
                     </div>
                   </a>
                 </div>
               <?php
                }
                ?>

               <div class="col-12">
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
               </div>
             </div>
           </div>
           <div class="col-lg-3">
             <div class="row g-4">
               <div class="col-lg-12">
                 <div class="mb-3">
                   <h4>Thương hiệu</h4>
                   <ul class="list-unstyled fruite-categorie">
                     <div class="mb-2">
                       <input type="checkbox" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">
                       <label for="Categories-1"> Casio</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">
                       <label for="Categories-2"> Omega</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">
                       <label for="Categories-3"> Tissot</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">
                       <label for="Categories-4"> Carnival</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">
                       <label for="Categories-5"> Bentley</label>
                     </div>
                   </ul>
                 </div>
               </div>

               <div class="col-lg-12">
                 <div class="mb-3">
                   <h4>Loại dây</h4>
                   <div class="mb-2">
                     <input type="checkbox" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">
                     <label for="Categories-1"> Dây kim loại</label>
                   </div>
                   <div class="mb-2">
                     <input type="checkbox" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">
                     <label for="Categories-2"> Nhựa tổng hợp</label>
                   </div>
                   <div class="mb-2">
                     <input type="checkbox" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">
                     <label for="Categories-3"> Dây cao su</label>
                   </div>
                   <div class="mb-2">
                     <input type="checkbox" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">
                     <label for="Categories-4"> Vải</label>
                   </div>
                   <div class="mb-2">
                     <input type="checkbox" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">
                     <label for="Categories-5"> Chất liệu khác</label>
                   </div>
                 </div>
               </div>
               <div class="col-lg-12">
                 <div class="mb-3">
                   <h4 class="mb-2">Giá</h4>
                   <div class="mb-2">
                     <input type="radio" class="me-2" id="Categories-1" name="Categories-1" value="Beverages">
                     <label for="Categories-1"> Dưới 1 triệu</label>
                   </div>
                   <div class="mb-2">
                     <input type="radio" class="me-2" id="Categories-2" name="Categories-1" value="Beverages">
                     <label for="Categories-2"> 1-2 triệu</label>
                   </div>
                   <div class="mb-2">
                     <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Beverages">
                     <label for="Categories-3"> 2-5 triệu</label>
                   </div>
                   <div class="mb-2">
                     <input type="radio" class="me-2" id="Categories-4" name="Categories-1" value="Beverages">
                     <label for="Categories-4"> 5-20 triệu</label>
                   </div>
                   <div class="mb-2">
                     <input type="radio" class="me-2" id="Categories-5" name="Categories-1" value="Beverages">
                     <label for="Categories-5"> Trên 20 triệu</label>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
   </div>
   <?php
    include "footer.php";
    ?>