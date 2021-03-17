<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class EmailTemplateDao extends BaseDao{

  public function __construct(){
    parent::__construct("email_templates");
  }

  public function get_email_templates($account_id, $offset, $limit, $search, $order){
    list($order_column, $order_direction) = self::parse_order($order);

    $params = ["account_id" => $account_id];
    $query = "SELECT *
              FROM email_templates
              WHERE account_id = :account_id ";

    if (isset($search)){
      $query .= "AND ( LOWER(name) LIKE CONCAT('%', :search, '%') OR LOWER(subject) LIKE CONCAT('%', :search, '%'))";
      $params['search'] = strtolower($search);
    }
    
    $query .="ORDER BY ${order_column} ${order_direction} ";
    $query .="LIMIT ${limit} OFFSET ${offset}";

    return $this->query($query, $params);
  }
}
?>
