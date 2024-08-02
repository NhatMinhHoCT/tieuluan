<?php

namespace Controller;

use Model\Product;
use Model\Database;

class ProductController
{
  public function insertProduct($name, $code, $status, $idSupplier, $image, $price, $description, $kind, $machineType, $color, $origin, $diameter, $watchChain, $guarantee)
  {
    $db = new Database();
    $sql = "INSERT INTO product (name, code, status, idSupplier, image, price, description, kind, machineType, color, origin, diameter, watchChain, guarantee)
    VALUES ('$name', '$code', '$status', '$idSupplier', '$image', '$price', '$description', '$kind', '$machineType', '$color', '$origin', '$diameter', '$watchChain', '$guarantee')";
    return $db->execute($sql);
  }

  public function updateProduct($idProduct, $name, $status, $idSupplier, $image, $price, $description, $kind, $machineType, $color, $origin, $diameter, $watchChain, $guarantee)
  {
    $db = new Database();
    $sql = "UPDATE product SET name = '$name',status='$status', idSupplier = '$idSupplier', image = '$image', price = '$price', description = '$description', kind = '$kind', machineType = '$machineType', color = '$color', origin = '$origin', diameter = '$diameter', watchChain = '$watchChain', guarantee = '$guarantee' WHERE idProduct = '$idProduct'";
    return $db->execute($sql);
  }
  public function countProduct($search, $supplier, $chain, $price, $kind)
  {
    $db = new Database();
    $sql = "SELECT count(idProduct) as count FROM product WHERE 1=1";
    if ($kind != null) {
      $sql .= " AND kind = '$kind'";
    }
    if ($search != null) {
      $sql .= " AND name LIKE '%$search%'";
    }
    if (!empty($supplier)) {
      $supplierIds = implode(',', array_map('intval', $supplier));
      $sql .= " AND idSupplier IN ($supplierIds)";
    }
    if (!empty($chain)) {
      $chainIds = implode(',', array_map('intval', $chain));
      $sql .= " AND watchChain IN ($chainIds)";
    }
    if (!empty($price)) {
      switch ($price[0]) {
        case '1':
          $sql .= " AND price < 1000000";
          break;
        case '2':
          $sql .= " AND price BETWEEN 1000000 AND 1999999";
          break;
        case '3':
          $sql .= " AND price BETWEEN 2000000 AND 5000000";
          break;
        case '4':
          $sql .= " AND price > 5000000";
          break;
        default:
          break;
      }
    }
    return $result = $db->fetch($sql);
    if ($result) {
      return $result[0]['count'];
    }
    return null;
  }
  public function getProduct($search, $supplier, $chain, $price, $kind, $start, $limit,$category)
  {
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM product WHERE 1=1";
    if ($kind != null) {
      $sql .= " AND kind = '$kind'";
    }
    if ($search != null) {
      $sql .= " AND name LIKE '%$search%'";
    }
    if (!empty($supplier)) {
      $supplierIds = implode(',', array_map('intval', $supplier));
      $sql .= " AND idSupplier IN ($supplierIds)";
    }
    if (!empty($chain)) {
      $chainIds = implode(',', array_map('intval', $chain));
      $sql .= " AND watchChain IN ($chainIds)";
    }
    if (!empty($price)) {
      switch ($price[0]) {
        case '1':
          $sql .= " AND price < 1000000";
          break;
        case '2':
          $sql .= " AND price BETWEEN 1000000 AND 1999999";
          break;
        case '3':
          $sql .= " AND price BETWEEN 2000000 AND 5000000";
          break;
        case '4':
          $sql .= " AND price > 5000000";
          break;
        default:
          break;
      }
    }
    switch ($category) {
      case '1':
        $sql .= " ORDER BY RAND() DESC LIMIT {$start}, {$limit}";
        break;
      case '2':
        $sql .= " ORDER BY idProduct DESC LIMIT {$start}, {$limit}";
        break;
      case '3':
        $sql .= " AND status=2 ORDER BY idProduct DESC LIMIT {$start}, {$limit}";
        break;
      case '4':
        $sql .= " ORDER BY idProduct DESC";
        break;
      default:
        break;
    }
    
    // var_dump($sql);
    $result = $db->fetch($sql);
    if ($result) {
      foreach ($result as $row) {
        $data[] = new Product(
          $row['idProduct'],
          $row['name'],
          $row['code'],
          $row['status'],
          $row['idSupplier'],
          $row['image'],
          $row['price'],
          $row['description'],
          $row['kind'],
          $row['machineType'],
          $row['color'],
          $row['origin'],
          $row['diameter'],
          $row['watchChain'],
          $row['guarantee']
        );
      }
      return $data;
    }
    return null;
  }

  public function getProduct_detail($id)
  {
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM product WHERE '$id' = idProduct";
    $sql .= " ORDER BY idProduct DESC";
    $result = $db->fetch($sql);
    if ($result) {
      foreach ($result as $row) {
        $data = new Product(
          $row['idProduct'],
          $row['name'],
          $row['code'],
          $row['status'],
          $row['idSupplier'],
          $row['image'],
          $row['price'],
          $row['description'],
          $row['kind'],
          $row['machineType'],
          $row['color'],
          $row['origin'],
          $row['diameter'],
          $row['watchChain'],
          $row['guarantee']
        );
      }
      return $data;
    }
    return null;
  }
  public function getProductLimited($start, $limit)
  {
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM product WHERE status=2";
    $sql .= " ORDER BY idProduct DESC LIMIT {$start}, {$limit}";
    // var_dump($sql);
    $result = $db->fetch($sql);
    if ($result) {
      foreach ($result as $row) {
        $data[] = new Product(
          $row['idProduct'],
          $row['name'],
          $row['code'],
          $row['status'],
          $row['idSupplier'],
          $row['image'],
          $row['price'],
          $row['description'],
          $row['kind'],
          $row['machineType'],
          $row['color'],
          $row['origin'],
          $row['diameter'],
          $row['watchChain'],
          $row['guarantee']
        );
      }
      return $data;
    }
    return null;
  }
}
