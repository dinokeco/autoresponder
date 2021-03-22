<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/AccountDao.class.php';

class AccountService extends BaseService{

  public function __construct(){
    $this->dao = new AccountDao();
  }

  public function get_accounts($search, $offset, $limit, $order){
    if ($search){
      return $this->dao->get_accounts($search, $offset, $limit, $order);
    }else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function add($account){
    // validation of account data
    if (!isset($account['name'])) throw new Exception("Name is missing");
    $account['created_at'] = date(Config::DATE_FORMAT);
    return parent::add($account);
  }


}
?>
