<?php

namespace Controller;

use Model\Database;
use Model\Orders;

class OrderController
{
  public function __construct()
  {
  }
  public function getOrderAll($id_customer,$search, $start, $limit)
  {
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM orders WHERE 1=1";
    if ($search != null) {
      $sql .= " AND order_code LIKE '%$search%'";
    }
    if($id_customer!=null){
      $sql .= " AND customer_id = '$id_customer'";
    }
    $sql .= " ORDER BY idOrder DESC LIMIT {$start}, {$limit} ";

    $result = $db->fetch($sql);
    if ($result) {
      foreach ($result as $row) {
        $data[] = new Orders(
          $row['idOrder'],
          $row['order_code'],
          $row['customer_id'],
          $row['shipping_receiver'],
          $row['shipping_phone'],
          $row['shipping_address'],
          $row['total_amount'],
          $row['order_date'],
          $row['payment_method'],
          $row['note'],
          $row['state'],
        );
      }
      return $data;
    }
    return null;
  }
  public function countOrderAll($id_customer,$search)
  {
    $db = new Database();
    $sql = "SELECT  count(idOrder) as count FROM orders WHERE 1=1";
    if ($search != null) {
      $sql .= " AND order_code LIKE '%$search%'";
    }
    if ($id_customer != null) {
      $sql .= " AND customer_id = '$id_customer'";
    }
    $result = $db->fetch($sql);
    if ($result) {
      return $result[0]['count'];
    }
    return null;
  }
  public function getOrderById($id){
    $db = new Database();
    $sql = "SELECT * FROM orders 
    join order_detail on order_detail.order_id = orders.idOrder
    join product on product.idProduct = order_detail.product_id
    WHERE idOrder = $id";
    $result = $db->fetch($sql);
    if ($result) {
      return $result;
    }
    return null;
  }
  public function updateOrder($id, $state){
    $db = new Database();
    $sql = "UPDATE orders SET state = $state WHERE idOrder = $id";
    $result = $db->execute($sql);
    if ($result) {
      return true;
    }
    return false;
  }
  public function order_count_day(){
    $db = new Database();
    $sql = "SELECT COUNT(idOrder) as count, DATE(order_date) as date FROM orders WHERE DATE(order_date) = CURDATE() GROUP BY DATE(order_date)";
    $result = $db->fetch($sql);
    if ($result) {
      return $result;
    }
    return null;
  }
  public function order_count_month()
  {
    $db = new Database();
    $sql = "SELECT COUNT(idOrder) as count, MONTH(order_date) as month FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) GROUP BY MONTH(order_date)";
    $result = $db->fetch($sql);
    if ($result) {
      return $result;
    }
    return null;
  }
  public function order_sum_month(){
    $db = new Database();
    $sql = "SELECT SUM(total_amount) as sum, MONTH(order_date) as month FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) GROUP BY MONTH(order_date)";
    $result = $db->fetch($sql);
    if ($result) {
      return $result;
    }
    return null;
  }
  public function getOrdersAndRevenueForLastSevenDays()
  {
    $db = new Database();
    $data = array();
    $startDate = date('Y-m-d', strtotime('-7 days'));
    $endDate = date('Y-m-d');

    for ($date = $startDate; $date <= $endDate; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
      $sql = "SELECT COUNT(idOrder) AS order_count, SUM(total_amount) AS revenue 
                FROM orders 
                WHERE DATE(order_date) = '$date'";
      $result = $db->fetch($sql);

      if ($result) {
        $data[] = array(
          'date' => $date,
          'order_count' => $result[0]['order_count'],
          'revenue' => $result[0]['revenue']
        );
      } else {
        $data[] = array(
          'date' => $date,
          'order_count' => 0,
          'revenue' => 0
        );
      }
    }

    return $data;
  }
}
