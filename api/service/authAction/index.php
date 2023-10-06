<?php
require 'utils.php';

class Auth extends AuthUtils {
  /* Get Auth */
  public function getAuth () {
    if(!$this->isLogin()) return res(401, 'Vui lòng đăng nhập tài khoản trước');

    // Check Token
    $authCheck = $this->getAuthCheckByToken();
    
    // Check
    if(empty($authCheck))
      res(401, 'Không thể xác thực tài khoản');
    if((int)$authCheck['block'] == 1)
      res(401, 'Tài khoản của bạn đang bị khóa');

    $account = $authCheck['account'];
    $user = (new User())->getUser($account);
    return $user;
  }

  /* Sign In */
  public function signIn () {
    if(empty($_POST['account']) || empty($_POST['password']))
      res(400, 'Vui lòng nhập đủ thông tin');

    // No Format
    $account = trim($_POST['account']);
    $password = md5(trim($_POST['password']));
    if(preg_match("/\\s/", $account))
      res(400, 'Tài khoản không để khoảng trắng');

    // Get Auth Check By Account
    $authCheck = $this->getAuthCheckByAccount($account);

    // Check
    if(empty($authCheck))
      res(400, 'Tài khoản không tồn tại');
    if($authCheck['password'] != $password)
      res(400, 'Mật khẩu không chính xác');
    if((int)$authCheck['block'] == 1)
      res(400, 'Tài khoản của bạn đang bị khóa');

    // Set Auth
    $token = $this->setAuth($account, $password);

    // Done
    $user = (new User())->getUser($account);
    $user['token'] = $token;
    return array('msg' => 'Đăng nhập thành công', 'data' => $user);
  }

  /* Sign Up */
  public function signUp () {
    if(empty($_POST['account']) || empty($_POST['password']) || empty($_POST['phone']))
      res(400, 'Vui lòng nhập đủ thông tin');
    
    // No Format
    $account = trim(strtolower($_POST['account']));
    $password = trim($_POST['password']);
    $phone = trim(strtolower($_POST['phone']));

    // Validate
    if(strlen($account) < 6 || strlen($account) > 15)
      res(400, 'Tên tài khoản trong khoảng từ 5-15 ký tự');
    if(!preg_match('/^[a-z\d]{6,15}$/i', $account))
      res(400, 'Tên tài khoản không chứa ký tự đặc biệt');
    if(preg_match("/\\s/", $account))
      res(400, 'Tài khoản không để khoảng trắng');

    if(strlen($password) < 6 || strlen($password) > 15)
      res(400, 'Mật khẩu trong khoảng từ 5-15 ký tự');
    if(preg_match("/\\s/", $password))
      res(400, 'Mật khẩu không để khoảng trắng');

    if(preg_match("/\\s/", $phone))
      res(400, 'Số điện thoại không để khoảng trắng');
    if(!preg_match('/^[0-9]{10}+$/', $phone))
      res(400, 'Định dạng số điện thoại không hợp lệ');

    // Get Auth Check By Account
    $authCheck = $this->getAuthCheckByAccount($account);
    if(!empty($authCheck))
      res(400, 'Tài khoản đã tồn tại');

    // Get Auth Check By Phone
    $authCheck = $this->getAuthCheckByPhone($phone);
    if(!empty($authCheck))
      res(400, 'Số điện thoại đã tồn tại');

    // Check Ads
    $listAds = (new Ads())->getAllAds();
    if(count($listAds) > 0){
      if(!is_numeric($_POST['reg_from']))
        res(400, 'Vui lòng chọn nguồn biết đến trò chơi');
      $ads = (new Ads())->getAds($_POST['reg_from']);
      $reg_from = $ads['id'];
    }
    else {
      $reg_from = 0;
    }

    // Check Referraler And Create User
    if(!empty($_POST['referral_code'])){
      $referraler = $this->getReferralerByCode(($_POST['referral_code']));
      (new User())->createUserWithReferraler($account, $referraler);
    }
    else {
      (new User())->createUserNoReferraler($account);
    }

    // Create Auth
    $password = md5($password);
    $referral_code = $this->makeReferralCode($account);
    (new _PDO())->create('ny_auth', array(
      'account' => (string)$account,
      'password' => (string)$password,
      'phone' => (string)$phone,
      'referral_code' => (string)$referral_code,
      'reg_from' => (int)$reg_from,
      'referraler' => !empty($referraler) ? $referraler : null
    ));

    // Set Auth
    $token = $this->setAuth($account, $password);

    // Done
    $user = (new User())->getUser($account);
    $user['token'] = $token;
    return array('msg' => 'Đăng ký thành công', 'data' => $user);
  }

  /* Sign Out */
  public function signOut () {
    $this->setAuth(null, null);
    return array('msg' => null, 'data' => null);
  }

  /* Sign Forgot */
  public function signForgot () {
    if(empty($_POST['account']) || empty($_POST['password']) || empty($_POST['phone']))
      res(400, 'Vui lòng nhập đủ thông tin');

    // No Format
    $account = trim($_POST['account']);
    $password = trim($_POST['password']);
    $phone = trim(strtolower($_POST['phone']));

    // Validate
    if(strlen($password) < 6 || strlen($password) > 15)
      res(400, 'Mật khẩu trong khoảng từ 5-15 ký tự');
    if(preg_match("/\\s/", $password))
      res(400, 'Mật khẩu không để khoảng trắng');

    // Get Auth Check By Account
    $authCheck = $this->getAuthCheckByAccount($account);
    if(empty($authCheck))
      res(400, 'Tài khoản không tồn tại');
    if(empty($authCheck['phone']))
      res(400, 'Tài khoản chưa có số điện thoại, không thể lấy lại');
    if($authCheck['phone'] != $phone)
      res(400, 'Số điện thoại đăng ký không chính xác');

    // Update
    $this->updateAuth($account, array(
      'password' => md5($password)
    ));

    // Set Auth
    $this->setAuth($account, $password);

    return array('msg' => 'Lấy lại mật khẩu thành công', 'data' => null);
  }

  /* Change Password */
  public function changePassword ($user) {
    if(empty($_POST['password']) || empty($_POST['old_password'])) return res(400, 'Vui lòng nhập đủ dữ liệu');

    // Format
    $account = $user['account'];
    $old_password = md5(trim($_POST['old_password']));
    $password = trim($_POST['password']);
    $authCheck = $this->getAuthCheckByAccount($account);

    // Check Old Password
    if($authCheck['password'] != $old_password)
      res(400, 'Mật khẩu cũ không chính xác');

    // Validate
    if(strlen($password) < 6 || strlen($password) > 15)
      res(400, 'Mật khẩu trong khoảng từ 5-15 ký tự');
    if(preg_match("/\\s/", $password))
      res(400, 'Mật khẩu không để khoảng trắng');

    // MD5 Password
    $password = md5($password);

    // Update
    $this->updateAuth($account, array(
      'password' => $password
    ));

    // Set Auth
    $this->setAuth($account, $password);

    return array('msg' => 'Đổi mật khẩu thành công', 'data' => null);
  }

  /* Update Auth Bank */
  public function updateAuthBank ($user) {
    if(empty($_POST['name']) || empty($_POST['person']) || empty($_POST['stk'])) return res(400, 'Vui lòng nhập đủ dữ liệu');

    // Check
    if(!empty($user['bank_name']))
      res(400, 'Bạn không thể cập nhật lại dữ liệu này');

    // Update
    $this->updateAuth($user['account'], array(
      'bank_name' => (string)$_POST['name'],
      'bank_person' => (string)$_POST['person'],
      'bank_stk' => (string)$_POST['stk']
    ));
  }

  /* Update Auth Phone */
  public function updateAuthPhone ($user) {
    if(empty($_POST['phone'])) return res(400, 'Vui lòng nhập đủ dữ liệu');

    // Check Phone
    if(!empty($user['phone']))
      res(400, 'Bạn không thể cập nhật lại dữ liệu này');

    // Check Phone
    $phone = trim(strtolower($_POST['phone']));
    if(!preg_match('/^[0-9]{10}+$/', $phone))
      res(400, 'Định dạng số điện thoại không hợp lệ');

    // Get Auth Check By Phone
    $authCheck = $this->getAuthCheckByPhone($phone);
    if(!empty($authCheck))
      res(400, 'Không thể sử dụng số điện thoại này');

    // Update
    $this->updateAuth($user['account'], array(
      'phone' => (string)$_POST['phone'],
    ));
  }
}