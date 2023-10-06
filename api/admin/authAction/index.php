<?php
require 'utils.php';

class Auth extends AuthUtils {
  /* Get Auth */
  public function getAuth ($type = 1) {
    if(!$this->isLogin()) return res(401, 'Vui lòng đăng nhập tài khoản trước');

    // Check Token
    $authCheck = $this->getAuthCheckByToken();
    
    // Check
    if(empty($authCheck))
      res(401, 'Không thể xác thực tài khoản');
    if((int)$authCheck['block'] == 1)
      res(401, 'Tài khoản của bạn đang bị khóa');
    if((int)$authCheck['type'] == 0)
      res(405, 'Bạn không có quyền truy cập');
    if((int)$authCheck['type'] < (int)$type)
      res(403, 'Bạn không có quyền thao tác chức năng này');

    $account = $authCheck['account'];
    $user = (new User())->getUser($account);
    return $user;
  }
}