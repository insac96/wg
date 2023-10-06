<?php
require 'pdo.php';

class AuthUtils extends AuthPDO {
  /* Is Auth */
  public function isLogin () {
    if(empty($_POST['token-auth'])) return false;
    return true;
  }

  /* Get Auth Check By Token */
  public function getAuthCheckByToken () {
    return (new _PDO())->select(self::$PDO_GetAuthCheckByToken, array('token'=>(string)$_POST['token-auth']));
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
}