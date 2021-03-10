<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__). "/dao/UserDao.class.php";

$user_dao = new UserDao();

//$user = $user_dao->get_user_by_id(3);

$user1 = [
  "password" => "password",
  "name" => "Becirevic Ahmed",
  "account_id" => 1,
  "email" => "ahmed1234@gmail.com"
];


$user = $user_dao->add_user($user1);

//$user_dao->get_user_by_email("dino.keco@gmail.com");

print_r($user);

?>
