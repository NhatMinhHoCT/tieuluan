<?php

namespace Controller;

use Model\Database;
use Model\Storage;

class StorageController
{
  public function __construct()
  {
  }
  // public function insertSupplier($nameSupplier, $email, $address, $phone, $description)
  // {
  //   $db = new Database();
  //   $sql = "INSERT INTO supplier (nameSupplier, email, address, phone, description )
  //   VALUES ('$nameSupplier', '$email','$address','$phone','$description')";
  //   return $db->execute($sql);
  // }
  public function countStorage($search)
  {
    $db = new Database();
    $sql = "SELECT count(idStorage) as count FROM storage 
    join product on storage.idProduct = product.idProduct 
    join supplier on product.idSupplier = supplier.idSupplier WHERE 1=1";
    if ($search) {
      $sql .= " AND (product.name LIKE '%{$search}%' or supplier.nameSupplier LIKE '%{$search}%')";
    }
    return $result = $db->fetch($sql);
    if ($result) {
      return $result[0]['count'];
    }
    return null;
  }
  public function getStorage($search, $start, $limit)
  {
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM storage join product on storage.idProduct = product.idProduct 
    join supplier on product.idSupplier = supplier.idSupplier WHERE 1=1";
    if ($search) {
      $sql.= " AND (product.name LIKE '%{$search}%' or supplier.nameSupplier LIKE '%{$search}%')";
    }
    $sql .= " ORDER BY idStorage DESC LIMIT {$start}, {$limit}";
    $result = $db->fetch($sql);
    return $result;
    return null;
  }
  public function storage_update($idProduct, $quantity){
    $db = new Database();
    $sql = "UPDATE storage SET quantity = '$quantity' WHERE idProduct = '$idProduct'";
    return $db->execute($sql);
  }
  public function getStorageQuantity($idProduct){
    $db = new Database();
    $sql = "SELECT quantity FROM storage WHERE idProduct = '$idProduct'";
    return $db->fetch($sql);
  }
  public function modifyStorage($idProduct, $quantity, $operation){
    $old_quantity = $this->getStorageQuantity($idProduct)[0]['quantity'];
    switch ($operation) {
      case '1':
        $new_quantity = $old_quantity + $quantity;    
        break;
      case '2':
        $new_quantity = $old_quantity - $quantity;
        break;
    }
    return $this->storage_update($idProduct, $new_quantity); 
  }
  public function checkStorage($idProduct, $quantity){
    $old_quantity= $this->getStorageQuantity($idProduct)[0]['quantity'];
    if($old_quantity >= $quantity){
      return true;
    }else{
      return false;
    }
  }
  public function emptyStorage($idProduct){
    $old_quantity = $this->getStorageQuantity($idProduct)[0]['quantity'];
    if($old_quantity == 0){
      return true;
    }else{
      return false;
    }
  }
}
