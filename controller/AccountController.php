<?php
include "../model/Account.php";
include "../model/Database.php";
class AccountController extends Account
{
  public function __construct()
  {
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
}
