<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao{

  public function __construct(){
    parent::__construct("accounts");
  }

  public function get_accounts($search, $offset, $limit){
    return $this->query("SELECT *
                         FROM accounts
                         WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                         LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
  }

}
?>
