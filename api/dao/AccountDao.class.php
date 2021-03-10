<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao{

  public function __construct(){
    parent::__construct("accounts");
  }

  public function get_all_accounts(){
    return $this->query("SELECT * FROM accounts", []);
  }

}
?>
