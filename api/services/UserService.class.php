<?php
require_once dirname(__FILE__). '/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';
require_once dirname(__FILE__).'/../dao/AccountDao.class.php';

require_once dirname(__FILE__).'/../clients/SMTPClient.class.php';

class UserService extends BaseService{

  private $accountDao;

  private $smtpClient;

  public function __construct(){
    $this->dao = new UserDao();
    $this->accountDao = new AccountDao();
    $this->smtpClient = new SMTPClient();
  }

  public function reset($user){
    $db_user = $this->dao->get_user_by_token($user['token']);

    if (!isset($db_user['id'])) throw new Exception("Invalid token", 400);

    if (strtotime(date(Config::DATE_FORMAT)) - strtotime($db_user['token_created_at']) > 300) throw new Exception("Token expired", 400);

    $this->dao->update($db_user['id'], ['password' => md5($user['password']), 'token' => NULL]);

    return $db_user;
  }

  public function forgot($user){
    $db_user = $this->dao->get_user_by_email($user['email']);

    if (!isset($db_user['id'])) throw new Exception("User doesn't exists", 400);

    if (strtotime(date(Config::DATE_FORMAT)) - strtotime($db_user['token_created_at']) < 300) throw new Exception("Be patient tokens is on his way", 400);

    // generate token - and save it to db
    $db_user = $this->update($db_user['id'], ['token' => md5(random_bytes(16)), 'token_created_at' => date(Config::DATE_FORMAT)]);

    // send email
    //$this->smtpClient->send_user_recovery_token($db_user);
  }

  public function login($user){
    $db_user = $this->dao->get_user_by_email($user['email']);

    if (!isset($db_user['id'])) throw new Exception("User doesn't exists", 400);

    if ($db_user['status'] != 'ACTIVE') throw new Exception("Account not active", 400);

    $account = $this->accountDao->get_by_id($db_user['account_id']);
    if (!isset($account['id']) || $account['status'] != 'ACTIVE') throw new Exception("Account not active", 400);

    if ($db_user['password'] != md5($user['password'])) throw new Exception("Invalid password", 400);

    return $db_user;
  }

  public function register($user){
    if (!isset($user['account'])) throw new Exception("Account field is required");

    try {
      $this->dao->beginTransaction();
      $account = $this->accountDao->add([
        "name" => $user['account'],
        "status" => "PENDING",
        "created_at" => date(Config::DATE_FORMAT)
      ]);

      $user = parent::add([
        "account_id" => $account['id'],
        "name" => $user['name'],
        "email" => $user['email'],
        "password" => md5($user['password']),
        "status" => "PENDING",
        "role" => "USER",
        "created_at" => date(Config::DATE_FORMAT),
        "token" => md5(random_bytes(16))
      ]);
      $this->dao->commit();
    } catch (\Exception $e) {
      $this->dao->rollBack();
      if (str_contains($e->getMessage(), 'users.uq_user_email')) {
        throw new Exception("Account with same email exists in the database", 400, $e);
      }else{
        throw $e;
      }
    }

    //  $this->smtpClient->send_register_user_token($user);

    return $user;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);

    if (!isset($user['id'])) throw new Exception("Invalid token", 400);

    $this->dao->update($user['id'], ["status" => "ACTIVE", "token" => NULL]);
    $this->accountDao->update($user['account_id'], ["status" => "ACTIVE"]);

    return $user;
  }

}
?>
