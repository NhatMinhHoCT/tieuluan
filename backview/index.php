<?php
include "header.php";
$page_title = "trangchu";
include "navside.php";

use Controller\AccountController;
use Controller\OrderController;

$accountController = new AccountController();
$chartData = $accountController->getChartData();

$order = new OrderController();
$ordersAndRevenueData = $order->getOrdersAndRevenueForLastSevenDays();

// Prepare data for the bar chart (order count)
$orderCountLabels = array_column($ordersAndRevenueData, 'date');
$orderCountData = array_column($ordersAndRevenueData, 'order_count');

// Prepare data for the line chart (revenue)
$revenueLabels = array_column($ordersAndRevenueData, 'date');
$revenueData = array_column($ordersAndRevenueData, 'revenue');

?>




<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-sm-6 col-xl-3">
      <div class="border border-primary border-3 rounded d-flex align-items-center justify-content-between p-4">
        <i class="fa fa-cart-plus chart-line fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Đơn hàng mới/ngày</p>
          <h6 class="mb-0"><?php echo $order->order_count_day()[0]['count']??'0' ?></h6>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="border border-primary border-3 rounded d-flex align-items-center justify-content-between p-4">
        <i class="fa fa-chart-bar fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Đơn hàng/tháng</p>
          <h6 class="mb-0"><?php echo $order->order_count_month()[0]['count'] ?></h6>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="border border-primary border-3 rounded d-flex align-items-center justify-content-between p-4">
        <i class="fa fa-users -chart-area fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Thành viên</p>
          <h6 class="mb-0"><?php echo $accountController->countAccount(null) ?></h6>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="border border-primary border-3 rounded d-flex align-items-center justify-content-between p-4">
        <i class="fa fa-coins  chart-pie fa-3x text-primary"></i>
        <div class="ms-3">
          <p class="mb-2">Doanh số tháng</p>
          <h6 class="mb-0"><?php echo number_format($order->order_sum_month()[0]['sum'], 0, ',', '.') ?> đ </h6>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Sale & Revenue End -->


<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
  <div class="row g-4">
    <div class="col-sm-12 col-xl-6">
      <div class="border border-primary border-3 text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h6 class="mb-0">Số lượng đơn hàng trong 7 ngày gần nhất</h6>
        </div>
        <canvas id="barChart"></canvas>
      </div>
    </div>
    <div class="col-sm-12 col-xl-6">
      <div class="border border-primary border-3 text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h6 class="mb-0">Doanh số trong 7 ngày gần nhất</h6>
        </div>
        <canvas id="line-chart"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Sales Chart End -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Bar Chart for Order Count
  var orderCountCtx = document.getElementById('barChart').getContext('2d');
  var orderCountChart = new Chart(orderCountCtx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($orderCountLabels); ?>,
      datasets: [{
        label: 'Số lượng đơn hàng',
        data: <?php echo json_encode($orderCountData); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.5)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  // Line Chart for Revenue
  var revenueCtx = document.getElementById('line-chart').getContext('2d');
  var revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($revenueLabels); ?>,
      datasets: [{
        label: 'Doanh số',
        data: <?php echo json_encode($revenueData); ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 0.5)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<?php
include "footer.php";
?>