<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CustomerDao extends BaseDao{

  public function __construct(){
    parent::__construct("customers");
  }

  public function get_all_customers(){
    return $this->query("SELECT * FROM customers", []);
  }

}
?>
