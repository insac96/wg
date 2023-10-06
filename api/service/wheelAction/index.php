<?php
require 'utils.php';

class Wheel extends WheelUtils {
  /* Get Wheel */
  public function getWheel () {
    $gifts = $this->getAllWheelGift();
    $logs = $this->getAllWheelLog();
    $world = $this->getAllWheelLogWorld();

    return array(
      'gifts' => $gifts,
      'logs' => $logs,
      'world' => $world
    );
  }

  /* Spin Wheel */
  public function spinWheel ($user) {
    // Check Server
    if(empty($_POST['server_id']))
      res(400, 'Vui lòng chọn máy chủ trước');

    // Check User Wheel
    if((int)$user['wheel'] == 0)
      res(400, 'Bạn đã hết lượt quay, có thể mua tại cửa hàng hoặc nạp tiền để nhận thêm lượt');

    // Check Max Spin Wheel Day
    if((int)$user['spin_wheel_count'] >= (int)$user['vip']['max_spin_wheel'])
      res(400, 'Bạn đã đặt giới hạn lượt quay hôm nay, nâng cấp VIP để được quay thêm');

    // Check Delay
    $this->checkTimeDelay($user['account']);

    // Get Random Gift
    $gift = $this->getRandomGift();
    if(empty($gift))
      res(400, 'Lỗi không mong muốn, vui lòng thử lại');
    
    // Set Update Data
    $gift_type = $gift['type'];
    $gift_amount = $gift['amount'];
    $update = array();
    $action = '';

    // Check Gift Type
    if($gift_type == 'item') {
      $items = [];
      $items[] = array(
        'id' => (int)$gift['item_id'],
        'name' => (int)$gift['name'],
        'amount' => (int)$gift['amount'],
      );
      (new Game())->sendItems($user['account'], array(
        'server_id' => $_POST['server_id'],
        'items' => $items
      ));

      $action = 'Quay được ['.$gift['name'].']';
    }
    else {
      if($gift_type != 'unlucky'){
        $minus = $gift_type == 'wheel' ? 1 : 0;
        $update[$gift_type] = (int)$user[$gift_type] - (int)$minus + (int)$gift_amount;
        $action = 'Quay được ['.$gift['name'].']';
      }
      else {
        $action = 'Quay phải ô mất lượt';
      }
    }

    // Set Update Wheel
    $update = array_merge(
      array('wheel' => (int)$user['wheel'] - 1),
      array('spin_wheel_count' => (int)$user['spin_wheel_count'] + 1),
      $update
    );
    
    // Update User
    (new User())->updateUser($user['account'], $update);

    // Write Log
    (new _PDO())->create('ny_log_wheel', array(
      'account' => (string)$user['account'],
      'server_id' => (string)$_POST['server_id'],
      'gift_id' => (int)$gift['id'],
      'action' => (string)$action,
      'create_time' => time()
    ));

    // Return
    return $gift;
  }
}