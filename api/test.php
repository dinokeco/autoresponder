<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__). "/dao/UserDao.class.php";

$user_dao = new UserDao();

//$user = $user_dao->get_user_by_id(3);

$user1 = [
  "name" => "Faris Bektas",
  "email" => "ferecare@gmail.com",
  "password" => "1234",
  "account_id" => 1
];
$user = $user_dao->add_user($user1);

//$user_dao->get_user_by_email("dino.keco@gmail.com");

print_r($user);

?>
