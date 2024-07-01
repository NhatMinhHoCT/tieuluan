<?php

namespace Controller;

use Model\Database;
use Model\Supplier;

class SupplierController
{
  public function __construct()
  {
  }
  public function insertSupplier($nameSupplier, $email, $address, $phone, $description)
  {
    $db = new Database();
    $sql = "INSERT INTO supplier (nameSupplier, email, address, phone, description )
    VALUES ('$nameSupplier', '$email','$address','$phone','$description')";
    return $db->execute($sql);
  }
  public function countSupplier()
  {
    $db = new Database();
    $sql = "SELECT count(idSupplier) as count FROM supplier WHERE 1=1";
    return $result = $db->fetch($sql);
    if ($result) {
      return $result[0]['count'];
    }
    return null;
  }
  public function getSupplier($start, $limit)
  {
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM supplier WHERE 1=1";
    $sql .= " ORDER BY idSupplier DESC LIMIT {$start}, {$limit}";
    $result = $db->fetch($sql);
    if ($result) {
      foreach ($result as $row) {
        $data[] = new Supplier(
          $row['idSupplier'],
          $row['nameSupplier'],
          $row['description'],
          $row['address'],
          $row['email'],
          $row['phone'],
        );
      }
      return $data;
    }
    return null;
  }
  public function getSupplier_detail($id)
  {
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM supplier WHERE '$id' = idSupplier";
    $sql .= " ORDER BY idSupplier DESC";
    $result = $db->fetch($sql);
    if ($result) {
      foreach ($result as $row) {
        $data[] = new Supplier(
          $row['idSupplier'],
          $row['nameSupplier'],
          $row['description'],
          $row['address'],
          $row['email'],
          $row['phone'],
        );
      }
      return $data;
    }
    return null;
  }
  public function updateSupplier($idSupplier, $nameSupplier, $email, $address, $phone, $description)
  {
    $db = new Database();
    $sql = "UPDATE supplier SET nameSupplier = '$nameSupplier', email='$email', address='$address', phone='$phone',description='$description'  WHERE idSupplier = '$idSupplier'";
    return $db->execute($sql);
  }
}
