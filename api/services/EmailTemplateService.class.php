<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/EmailTemplateDao.class.php';

class EmailTemplateService extends BaseService{

  public function __construct(){
    $this->dao = new EmailTemplateDao();
  }

  public function add($email_template){
    try {
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
