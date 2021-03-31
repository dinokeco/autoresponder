<?php

require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CampaignDao.class.php';

class CampaignService extends BaseService{

  public function __construct(){
    $this->dao = new CampaignDao();
  }

  public function get_campaigns($account_id, $status, $offset, $limit, $search, $order){
    return $this->dao->get_campaigns($account_id, $status, $offset, $limit, $search, $order);
  }

  public function add_campaign($user, $campaign){
    try {
      $campaign['account_id'] = $user['aid'];
      $campaign['user_id'] = $user['id'];
      $campaign['status'] = 'ACTIVE';
      $campaign['created_at'] = date(Config::DATE_FORMAT);
      return parent::add($campaign);
    } catch (\Exception $e) {
      if (str_contains($e->getMessage(), 'campaigns.uq_campaign_name')) {
        throw new Exception("Campaign with same name already exists", 400, $e);
      }else{
        throw new Exception($e->getMessage(), 400, $e);
      }
    }
  }

  public function update_campaign($user, $id, $campaign){
    $db_campaign = $this->dao->get_by_id($id);
    if ($db_campaign['account_id'] != $user['aid']){
      throw new Exception("Invalid campaign", 403);
    }
    return $this->update($id, $campaign);
  }
}
?>
