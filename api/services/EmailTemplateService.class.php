<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/EmailTemplateDao.class.php';

class EmailTemplateService extends BaseService{

  public function __construct(){
    $this->dao = new EmailTemplateDao();
  }

  public function get_email_template_by_account_and_id($account_id, $id){
    return $this->dao->get_email_template_by_account_and_id($account_id, $id);
  }

  public function get_email_templates($account_id, $offset, $limit, $search, $order){
    return $this->dao->get_email_templates($account_id, $offset, $limit, $search, $order);
  }

  public function add($email_template){
    try {
      $email_template['created_at'] = date(Config::DATE_FORMAT);
      return parent::add($email_template);
    } catch (\Exception $e) {
      if (str_contains($e->getMessage(), 'email_templates.uq_email_template_name')) {
        throw new Exception("Email template with same name already exists", 400, $e);
      }else{
        throw $e;
      }
    }
  }

}
?>
