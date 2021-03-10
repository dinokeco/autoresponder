<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__). "/dao/UserDao.class.php";
require_once dirname(__FILE__). "/dao/AccountDao.class.php";
require_once dirname(__FILE__). "/dao/CampaignDao.class.php";

$dao = new CampaignDao();

$campaing = [
  "name" => "Flash sale of shooes",
  "account_id" => 1,
  "start_date" => date("Y-m-d H:i:s")
];
$dao->update(1, [
  "end_date" => "2021-04-01 00:00:00",
  "status" => "BLOCKED"
]);
$campaing = $dao->get_all_campaings();// $dao->add($campaing);
print_r($campaing);
?>
