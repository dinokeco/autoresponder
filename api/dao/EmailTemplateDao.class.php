<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class EmailTemplateDao extends BaseDao{

  public function __construct(){
    parent::__construct("email_templates");
  }
}
?>
