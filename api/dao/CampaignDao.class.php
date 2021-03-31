<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CampaignDao extends BaseDao{

  public function __construct(){
    parent::__construct("campaigns");
  }

  public function get_campaigns($account_id, $offset, $limit, $search, $order){
    list($order_column, $order_direction) = self::parse_order($order);
    $params = [];
    $query = "SELECT c.*, a.name AS account_name, u.name AS user_name, u.email
              FROM campaigns c JOIN
                   accounts a ON a.id = c.account_id JOIN
                   users u ON u.id = c.user_id
              WHERE 1 = 1 ";

    if ($account_id){
      $params["account_id"] = $account_id;
      $query .= "AND c.account_id = :account_id ";
    }

    if (isset($search)){
      $query .= "AND ( LOWER(c.name) LIKE CONCAT('%', :search, '%') OR
                       LOWER(a.name) LIKE CONCAT('%', :search, '%') OR
                       LOWER(u.name) LIKE CONCAT('%', :search, '%') OR
                       LOWER(u.email) LIKE CONCAT('%', :search, '%'))";
      $params['search'] = strtolower($search);
    }

    $query .="ORDER BY ${order_column} ${order_direction} ";
    $query .="LIMIT ${limit} OFFSET ${offset}";

    return $this->query($query, $params);
  }

}
?>
