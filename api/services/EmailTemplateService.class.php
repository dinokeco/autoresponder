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

  public function add_email_template($user, $email_template){
    try {
      // TODO: VALIDATION LAYER OF FIELDS

      // whitelist fields
      $data = [
        "name" => $email_template["name"],
        "subject" => $email_template["subject"],
        "body" => $email_template["body"],
        "account_id" => $user['aid'],
        "created_at" => date(Config::DATE_FORMAT)
      ];
      return parent::add($data);
    } catch (\Exception $e) {
      if (str_contains($e->getMessage(), 'email_templates.uq_email_template_name')) {
        throw new Exception("Email template with same name already exists", 400, $e);
      }else{
        throw new Exception($e->getMessage(), 400, $e);
      }
    }
  }

  public function update_email_template($user, $id, $email_template){
    $db_template = $this->dao->get_by_id($id);
    if ($db_template['account_id'] != $user['aid']){
      throw new Exception("Invalid email template", 403);
    }
    return $this->update($id, $email_template);
  }
}
?>
