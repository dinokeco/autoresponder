<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CampaignDao extends BaseDao{

  public function __construct(){
    parent::__construct("campaigns");
  }

  public function get_all_campaings(){
    return $this->query("SELECT * FROM campaigns", []);
  }

}
?>
