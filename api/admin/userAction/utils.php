<?php
require 'pdo.php';

class UserUtils extends UserPDO {
  /* Get User */
  public function getUser ($account) {
    $user = (new _PDO())->select(self::$PDO_GetUser, array('account'=>$account));

    if(empty($user)) return res(400, 'Tài khoản không tồn tại');
    return $user;
  }

  /* Update User */
  public function updateUser ($account, $update) {
    $where = array('account'=>$account);
    (new _PDO())->update('ny_user', $update, $where);
  }
}