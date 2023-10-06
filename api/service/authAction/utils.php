<?php
require 'pdo.php';
class AuthUtils extends AuthPDO {
  /* Is Auth */
  public function isLogin () {
    if(empty($_POST['token-auth'])) return false;
    return true;
  }

  /* Make Code */
  public function makeReferralCode ($account) {
    $config = (new Config())->getConfigAll();
    $prefix = !empty($config['prefix_referral']) ? $config['prefix_referral'] : 'R-';
    return $prefix.''.strtoupper($account);
  }

  /* Make Token and Set Auth */
  public function setAuth ($account, $password) {
    if(empty($account) || empty($password)){
      $token = null;
    }
    else {
      $key = $account.'-'.$password.'-'.time();
      $token = md5($key);
    }

    $this->updateAuth($account, array('token' => $token));
    return $token;
  }

  /* Sign */
  public function sign () {
    if(empty($_POST['type'])) 
      res(400, 'Kiểu dữ liệu không hỗ trợ');

    if($_POST['type'] == 'in') return $this->signIn();
    if($_POST['type'] == 'up') return $this->signUp();
    if($_POST['type'] == 'out') return $this->signOut();
    if($_POST['type'] == 'forgot') return $this->signForgot();

    res(400, 'Kiểu dữ liệu không hỗ trợ');
  }

  /* Get Auth Check By Token */
  public function getAuthCheckByToken () {
    return (new _PDO())->select(self::$PDO_GetAuthCheckByToken, array('token'=>(string)$_POST['token-auth']));
  }

  /* Get Auth Check By Account */
  public function getAuthCheckByAccount ($account) {
    return (new _PDO())->select(self::$PDO_GetAuthCheckByAccount, array('account'=>(string)$account));
  }

  /* Get Auth Check By Phone*/
  public function getAuthCheckByPhone ($phone) {
    return (new _PDO())->select(self::$PDO_GetAuthCheckByPhone, array('phone'=>(string)$phone));
  }

  /* Update Auth */
  public function updateAuth ($account, $update) {
    $where = array('account'=>$account);
    (new _PDO())->update('ny_auth', $update, $where);
  }

  /* Get Referraler */
  public function getReferralerByCode ($referral_code) {
    $referraler = (new _PDO())->select(self::$PDO_GetReferralerByCode, array('referral_code'=>(string)$referral_code));
    if(empty($referraler)) return res(400, 'Mã giới thiệu không chính xác');
    return $referraler['account'];
  }
}