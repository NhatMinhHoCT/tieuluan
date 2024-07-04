<?php

namespace Controller;

use Model\Account;
use Model\Database;

class AccountController
{
  public function __construct()
  {
  }
  public function getAccount($search, $start, $limit){
    $db = new Database();
    $data = array();
    $sql = "SELECT * FROM account WHERE 1=1";
    if ($search != null) {
      $sql .= " AND (guestname LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR address LIKE '%$search%')";
    }
    $sql .= " ORDER BY account_id DESC LIMIT {$start}, {$limit}";
    $result = $db->fetch($sql);
    if ($result) {
      foreach ($result as $row) {
        $data[] = new Account(
          $row['account_id'],
          $row['username'],
          $row['password'],
          $row['email'],
          $row['createdate'],
          $row['avatar'],
          $row['guestname'],
          $row['phone'],
          $row['address'],
          );
      }
      return $data;
    }
    return null;
  }
  public function countAccount($search)
  {
    $db = new Database();
    $sql = "SELECT count(account_id) as count FROM account WHERE 1=1";
    if ($search != null) {
      $sql .= " AND (guestname LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR address LIKE '%$search%')";
    }
    $result = $db->fetch($sql);
    if ($result) {
      return $result[0]['count'];
    }
    return null;
  }
  public function insertData($username, $password, $email)
  {
    $db = new Database();
    $hashpassword = sha1($password);
    $sql = "INSERT INTO account (username, password, email, role) VALUES ('$username', '$hashpassword', '$email', 2)";
    return $db->execute($sql);
  }
  public function checkLogin($username, $password)
  {
    $db = new Database();

    $hashedPassword = sha1($password);

    $sql = "SELECT * FROM account WHERE username = '$username' AND password = '$hashedPassword'";

    $result = $db->fetch($sql);

    if (!empty($result)) {
      session_start();
      $_SESSION['user_id'] = $result[0]['account_id'];
      $_SESSION['username'] = $result[0]['username'];
      $_SESSION['role'] = $result[0]['role'];
      $_SESSION['avatar'] = $result[0]['avatar'];
      return true;
    } else {
      return false;
    }
  }
  public function getAccountInfo($id)
  {
    $db = new Database();
    $sql = "SELECT * FROM account WHERE account_id = $id";
    $result = $db->fetch($sql);
    return $result;
  }
  public function getChartData()
  {
    $db = new Database();
    $sql = "SELECT YEAR(ngaytao) AS year, COUNT(*) AS record_count
            FROM thunghiem
            GROUP BY YEAR(ngaytao)
            ORDER BY year;";
    $result = $db->fetch($sql);
    // $data = array();
    // foreach ($result as $row) {
    //   $data[] = array(
    //     'country' => $row['country'],
    //     'orderCount' => $row['order_count']
    //   );
    // }
    // if ($result->num_rows > 0) {
    //   while ($row = $result->fetch_assoc()) {

    //   }
    // }
    // return $data;
    // return $result;
    return json_encode($result);
  }
  public function changePassword($account_id, $old_password, $new_password)
  {
    $db = new Database();
    if ($this->checkAccount($account_id, $old_password)) {
      $new_hashedPassword = sha1($new_password);
      $sql = "UPDATE account SET password = '$new_hashedPassword' WHERE account_id = '$account_id'";
      if ($db->execute($sql)) {
        return true;
      };
    } else {
      return false;
    }
  }
  public function checkAccount($account_id, $old_password)
  {
    $db = new Database();
    $hashedPassword = sha1($old_password);
    $sql = "SELECT account_id FROM account WHERE account_id = '$account_id' AND password = '$hashedPassword'";
    $result = $db->fetch($sql);
    if (!empty($result)) {
      return true;
    } else {
      return false;
    }
  }
  public function updateAccountInfo($account_id, $name, $email, $phone, $address){
    $db = new Database();
    $sql = "UPDATE account SET guestname = '$name', email = '$email', phone = '$phone', address = '$address' WHERE account_id = '$account_id'";
    if ($db->execute($sql)) {
      return true;
    } else {
      return false;
    }
  }
}
