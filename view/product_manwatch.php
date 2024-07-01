 <?php
  include "header.php";
  include "header_nav.php";

  use Controller\ProductController;
  use Controller\PaginationController;

  ?>
 < <div class="container-fluid py-5">
   <div class="container py-5">
     <div class="pb-5">
       <ol class="breadcrumb mb-0">
         <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
         <li class="breadcrumb-item"><a href="product_manwatch.php">Đồng hồ Nam</a></li>
       </ol>
     </div>
     <div class="row g-4">
       <div class="col-lg-12">
         <div class="row g-4">
           <div class="col-lg-9 row">
             <div class="col-xl-4">
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
             <div class="row g-4">
               <?php
                $product = new ProductController;
                $limit = 8;
                $kind = 1;
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($currentPage - 1) * $limit;
                if (isset($_GET['supplier']) || isset($_GET['search']) || isset($_GET['chain']) || isset($_GET['price'])) {
                  $supplier = $_GET['supplier'] ?? null;
                  $search = $_GET['search'] ?? null;
                  $chain = $_GET['chain'] ?? null;
                  $price = $_GET['price'] ?? null;
                  $totalItems = $product->countProduct($search, $supplier, $chain, $price, $kind);
                  $row = $product->getProduct($search, $supplier, $chain, $price, $kind, $start, $limit);
                } else {
                  $totalItems = $product->countProduct(null, null, null, null, $kind);
                  $row = $product->getProduct(null, null, null, null, $kind, $start, $limit);
                }
                $totalPages = ceil($totalItems[0]['count'] / $limit);

                if ($row != null) {
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
                           <p class="text-dark fw-bold text-uppercase"> <?php echo $data->code ?></p>
                           <div class="d-flex justify-content-center flex-lg-wrap">
                             <p class="text-dark fs-5 fw-bold mb-0"><?php echo number_format($data->price, 0, ',', '.') ?> vnd</p>
                           </div>
                         </div>
                       </div>
                     </a>
                   </div>
               <?php
                  }
                } else {
                  echo '<div class="col-12">';
                  echo '<img src="../include/img/original-c1597c0c2a6e0456d362549e47988f1b.png" class="img-fluid w-100" alt="image-search" >';
                  echo '</div>';
                }
                ?>

               <div class="col-12">
                 <?php
                  $queryParams = array(
                    'search' => $_GET['search'] ?? '',
                    'supplier' => $_GET['supplier'] ?? '',
                    'chain' => $_GET['chain'] ?? '',
                    'price' => $_GET['price'] ?? '',
                    'kind' => 1,
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
           <div class="col-lg-3">
             <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
               <div class="pb-5">
                 <div class="input-group w-100 mx-auto d-flex">
                   <input id="search" type="search" name="search" class="form-control p-3" placeholder="Tìm kiếm" aria-describedby="search-icon-1">
                   <button type="submit" class="btn btn-outline-primary"><i class="fa fa-search"></i></button>
                 </div>
               </div>
               <div class="row g-4">
                 <div class="col-lg-12">
                   <div class="mb-3">
                     <h4>Thương hiệu</h4>
                     <ul class="list-unstyled fruite-categorie">
                       <div class="mb-2">
                         <input type="checkbox" class="me-2 supplier_search" id="Casio" name="supplier[]" value="1">
                         <label for="Casio">Casio</label>
                       </div>
                       <div class="mb-2">
                         <input type="checkbox" class="me-2 supplier_search" id="Skagen" name="supplier[]" value="2">
                         <label for="Skagen">Skagen</label>
                       </div>
                       <div class="mb-2">
                         <input type="checkbox" class="me-2 supplier_search" id="Tissot" name="supplier[]" value="3">
                         <label for="Tissot">Tissot</label>
                       </div>
                       <div class="mb-2">
                         <input type="checkbox" class="me-2 supplier_search" id="Halminton" name="supplier[]" value="4">
                         <label for="Halminton">Halminton</label>
                       </div>
                       <div class="mb-2">
                         <input type="checkbox" class="me-2 supplier_search" id="CalvinKlein" name="supplier[]" value="5">
                         <label for="Calvin Klein">Calvin Klein</label>
                       </div>
                     </ul>
                   </div>
                 </div>

                 <div class="col-lg-12">
                   <div class="mb-3">
                     <h4>Loại dây</h4>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2 chain_search" id="chain1" name="chain[]" value="1">
                       <label for="chain1"> Dây kim loại</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2 chain_search" id="chain2" name="chain[]" value="2">
                       <label for="chain2"> Nhựa tổng hợp</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2 chain_search" id="chain3" name="chain[]" value="3">
                       <label for="chain3"> Dây cao su</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2 chain_search" id="chain4" name="chain[]" value="4">
                       <label for="chain4"> Vải</label>
                     </div>
                     <div class="mb-2">
                       <input type="checkbox" class="me-2 chain_search" id="chain5" name="chain[]" value="5">
                       <label for="chain5"> Chất liệu khác</label>
                     </div>
                   </div>
                 </div>
                 <div class="col-lg-12">
                   <div class="mb-3">
                     <h4 class="mb-2">Giá</h4>
                     <div class="mb-2">
                       <input type="radio" class="me-2 price_search" id="price1" name="price[]" value="1">
                       <label for="price1">Dưới 1 triệu</label>
                     </div>
                     <div class="mb-2">
                       <input type="radio" class="me-2 price_search" id="price2" name="price[]" value="2">
                       <label for="price2">1-2 triệu</label>
                     </div>
                     <div class="mb-2">
                       <input type="radio" class="me-2 price_search" id="price3" name="price[]" value="3">
                       <label for="price3">2-5 triệu</label>
                     </div>
                     <div class="mb-2">
                       <input type="radio" class="me-2 price_search" id="price4" name="price[]" value="4">
                       <label for="price4">Trên 5 triệu</label>
                     </div>
                   </div>
                 </div>
               </div>
             </form>
           </div>
         </div>
       </div>
     </div>
   </div>
   </div>
   <script>
     $(document).ready(function() {
       $('.supplier_search').each(function() {
         if ($.inArray($(this).val(), <?php echo isset($_GET['supplier']) ? json_encode($_GET['supplier']) : "" ?>) > -1) {
           $(this).prop('checked', true);
         }
       });
       $('.chain_search').each(function() {
         if ($.inArray($(this).val(), <?php echo isset($_GET['chain']) ? json_encode($_GET['chain']) : "" ?>) > -1) {
           $(this).prop('checked', true);
         }
       });
       $('.price_search').each(function() {
         $('#search').val('<?php echo $_GET['search'] ?? "" ?>');
         if ($.inArray($(this).val(), <?php echo isset($_GET['price']) ? json_encode($_GET['price']) : "" ?>) > -1) {
           $(this).prop('checked', true);
         }
       });
     });
   </script>
   <?php
    include "footer.php";
    ?>