<?php

namespace Model;

class Storage
{
  public $idStorage;
  public $idProduct;
  public $quantity;
  public function __construct($idStorage, $idProduct,$quantity)
  {
    $this->idStorage = $idStorage;
    $this->idProduct = $idProduct;
    $this->quantity = $quantity;
    }
}
