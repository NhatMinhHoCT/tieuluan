<?php

namespace Controller;
use Model\Database;

class ImportController
{
 public function __construct(){

 }
 public function insertImport($product_id, $quantity, $date_import, $note){
    $db = new Database();
    $sql = "INSERT INTO imports (product_id, quantity, date_import, note) VALUES ('$product_id', '$quantity', '$date_import', '$note')";
    return $db->execute($sql);
  }
}
