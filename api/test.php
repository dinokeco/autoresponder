<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__). "/dao/UserDao.class.php";
require_once dirname(__FILE__). "/dao/AccountDao.class.php";

$dao = new AccountDao();

$dao->update(3, [
  "name" => "Master Vision"

]);


$accounts = $dao->get_by_id(3);
print_r($accounts);
?>
