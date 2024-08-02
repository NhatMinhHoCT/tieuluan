<?php

namespace model;

class Orders
{
  public $idOrder;
  public $order_code;
  public $customer_id;
  public $shipping_receiver;
  public $shipping_phone;
  public $shipping_address;
  public $total_amount;
  public $order_date;
  public $payment_method;
  public $note;
  public $state;

  public function __construct(
    $idOrder,
    $order_code,
    $customer_id,
    $shipping_receiver,
    $shipping_phone,
    $shipping_address,
    $total_amount,
    $order_date,
    $payment_method,
    $note,
    $state,
  ) {
    $this->idOrder = $idOrder;
    $this->order_code=$order_code;
    $this->customer_id = $customer_id;
    $this->shipping_receiver = $shipping_receiver;
    $this->shipping_phone = $shipping_phone;
    $this->shipping_address = $shipping_address;
    $this->total_amount = $total_amount;
    $this->order_date = $order_date;
    $this->payment_method = $payment_method;
    $this->note = $note;
    $this->state = $state;
  }
}
