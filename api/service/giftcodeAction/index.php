<?php
require 'utils.php';

class Giftcode extends GiftcodeUtils {
  /* Get Giftcode By Name */
  public function getGiftcode ($user) {
    if(empty($_POST['giftcode']) || empty($_POST['server_id'])) return res(400, 'Vui lòng nhập mã');

    // Get Giftcode
    $giftcode = (new _PDO())->select(self::$PDO_GetGiftCode, array('name' => $_POST['giftcode']));
    if(empty($giftcode)) return res(400, 'Mã không tồn tại');

    // Get Received
    $received = (new _PDO())->select(self::$PDO_GetReceived, array(
      'account' => (string)$user['account'],
      'giftcode_id' => (int)$giftcode['id'],
      'server_id' => (string)$_POST['server_id']
    ));

    // Check
    if(!empty($received))
      res(400, 'Bạn đã nhận quà mã này rồi');
    if(isExpires($giftcode['expires_time']))
      res(400, 'Mã đã hết hiệu lực');
    if((int)$giftcode['max'] != 0 && (int)$giftcode['count'] >= (int)$giftcode['max'])
      res(400, 'Mã đã được sử dụng hết');
    if((string)$giftcode['server_id'] != 'all' && (string)$giftcode['server_id'] != (string)$_POST['server_id'])
      res(400, 'Mã này không áp dụng cho máy chủ bạn chọn');

    // Send Item To Game
    $items = (array)json_decode($giftcode['gifts']);
    (new Game())->sendItems($user['account'], array(
      'server_id' => $_POST['server_id'],
      'items' => $items
    ));

    // Update Count
    (new _PDO())->update('ny_giftcode', 
      array(
        'count' => array('+', 1)
      ), 
      array(
        'id' => $giftcode['id']
      )
    );

    // Save Log
    (new _PDO())->create('ny_log_giftcode', array(
      'account' => (string)$user['account'],
      'server_id' => (string)$_POST['server_id'],
      'giftcode_id' => (int)$giftcode['id'],
      'action' => 'Đã nhận quà từ Giftcode ['.$giftcode['name'].'] tại máy chủ ['.$_POST['server_id'].']',
      'create_time' => time()
    ));
  }
}