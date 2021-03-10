<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class EmailDao extends BaseDao{

  public function __construct(){
    parent::__construct("emails");
  }

  public function get_all_emails(){
    return $this->query("SELECT * FROM emails", []);
  }

}
?>
