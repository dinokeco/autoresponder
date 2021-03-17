<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao{

  public function __construct(){
    parent::__construct("accounts");
  }

  public function get_accounts($search, $offset, $limit, $order){
    list($order_column, $order_direction) = self::parse_order($order);
    
    return $this->query("SELECT *
                         FROM accounts
                         WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                         ORDER BY ${order_column} ${order_direction}
                         LIMIT ${limit} OFFSET ${offset}",
                         ["name" => strtolower($search)]);
  }

}
?>
