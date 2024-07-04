<?php
namespace Model;
class Account
{
  public $account_id;
  public $username;
  public $password;
  public $email;
  public $createdate;
  public $avatar;
  public $guestname;
  public $phone;
  public $address;
  public function __construct($account_id, $username, $password, $email, $createdate, $avatar, $guestname, $phone, $address)
  {
    $this->account_id = $account_id;
    $this->username = $username;
    $this->password = $password;
    $this->email = $email;
    $this->createdate = $createdate;
    $this->avatar = $avatar;
    $this->guestname = $guestname;
    $this->phone = $phone;
    $this->address = $address;
  }
}
