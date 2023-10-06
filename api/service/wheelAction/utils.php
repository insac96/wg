<?php
require 'pdo.php';
class WheelUtils extends WheelPDO {
  /* Get All Wheel Gift */
  public function getAllWheelGift () {
    $list = (new _PDO())->select(self::$PDO_GetAllWheelGift, [], true);
    if(empty($list) || count($list) < 10) return null;
    return $list;
  }

  /* Get All Wheel Log */
  public function getAllWheelLog () {
    $authModel = new Auth();
    $user = $authModel->isLogin() ? $authModel->getAuth() : null;
    if(empty($user)) return null;
    
    $logs = (new _PDO())->select(self::$PDO_GetAllWheelLog, array('account' => $user['account']), true);
    return $logs;
  }

  /* Get All Wheel Log World */
  public function getAllWheelLogWorld () {
    $list = (new _PDO())->select(self::$PDO_GetAllWheelLogWorld, [], true);
    return $list;
  }
  
  /* Get Wheel Gift By ID */
  public function getWheelGift ($id) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID phần thưởng');

    $gift = (new _PDO())->select(self::$PDO_GetWheelGift, array('id' => $id));

    if(empty($gift)) return res(400, 'Phần thưởng không tồn tại');
    return $gift;
  }

  /* Check Time Delay */
  public function checkTimeDelay ($account) {
    $log = (new _PDO())->select(self::$PDO_GetLasWheelLog, array('account' => $account));
    if(empty($log)) return true;
    
    $last_time = $log['create_time'];
    $now_time = time();
    $check = (int)$last_time + 2;

    if($now_time < $check) return res('Delay mỗi lần quay là 2 giây');
  }

  /* Get Random Gift */
  public function getRandomGift () {
    $list = $this->getAllWheelGift();

    if(empty($list))
      res(400, 'Vòng quay đang bảo trì, vui lòng quay lại sau');

    // Value Init
    $chances = [];
    $acc = 0;
    $index = 0;

    // Total Percent
    $sum = array_sum(array_column($list, 'percent'));
    $sum = (float)$sum * 100;
    $rand = (mt_rand() / mt_getrandmax()) * (float)$sum;

    // Set Chances
    foreach ($list as $gift) {
      $acc = (float)$acc + (float)$gift['percent'] * 100;
      $chances[] = $acc;
    }

    // Make Index
    foreach ($chances as $value) {
      if((float)$value <= (float)$rand){
        $index = (int)$index + 1;
      }
    }
    
    // End Check
    $gift = $list[$index];
    if((float)$gift['percent'] <= 0.01){
        $randEnd = rand(0,1);
        if($randEnd == 1) return $gift;
        return $this->getWheelGift(1);
    }
    else {
        return $gift;
    }
  }
}