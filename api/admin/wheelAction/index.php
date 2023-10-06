<?php
require 'utils.php';

class Wheel extends WheelUtils {
  /* Get All Wheel Gift */
  public function getAllWheelGift () {
    return getTableList('ny_wheel_gift', self::$PDO_GetAllWheelGift);
  }

  /* Create Wheel Gift*/
  public function createWheelGift () {
    if(
      empty($_POST['name'])
      || empty($_POST['type'])
      || !is_numeric($_POST['amount'])
      || !is_float((float)$_POST['percent'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Gift Number And Percent
    if((int)$_POST['amount'] <= 0 && $_POST['type'] !== 'unlucky')
      res(400, 'Số lượng phải lớn hơn 0');
    if((int)$_POST['amount'] > 0 && $_POST['type'] == 'unlucky')
      res(400, 'Mất lượt thì không thể cài số lượng');
    if((float)$_POST['percent'] <= 0 || (float)$_POST['percent'] >= 1)
      res(400, 'Tỷ lệ phải lơn hơn 0 và nhỏ hơn 1');

    // Check Count Gift Wheel
    $count = getCountDB('ny_wheel_gift');
    if($count >= 10)
      res(400, 'Chỉ được phép có tối đa 10 phần thưởng');
      
    // Create
    (new _PDO())->create('ny_wheel_gift', array(
      'name' => (string)$_POST['name'],
      'type' => (string)$_POST['type'],
      'amount' => (int)$_POST['amount'],
      'percent' => (float)$_POST['percent'],
      'display' => (int)$_POST['display'],
      'item_id' => (int)$_POST['item_id'],
      'update_time' => time()
    ));

    logAdmin('Tạo phần thưởng vòng quay mới');
  }


  /* Update Wheel Gift */
  public function updateWheelGift () {
    if(
      empty($_POST['name'])
      || empty($_POST['type'])
      || !is_numeric($_POST['amount'])
      || !is_float((float)$_POST['percent'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Gift And Percent
    if((int)$_POST['amount'] <= 0 && $_POST['type'] != 'unlucky')
      res(400, 'Số lượng phải lớn hơn 0');
    if((int)$_POST['amount'] > 0 && $_POST['type'] == 'unlucky')
      res(400, 'Mất lượt thì không thể cài số lượng');
    if((float)$_POST['percent'] <= 0 || (float)$_POST['percent'] >= 1)
      res(400, 'Tỷ lệ phải lơn hơn 0 và nhỏ hơn 1');

    // Check Gift Wheel
    $gift = $this->getWheelGift($_POST['id']);

    // Update
    (new _PDO())->update('ny_wheel_gift', 
      array(
        'name' => (string)$_POST['name'],
        'type' => (string)$_POST['type'],
        'amount' => (int)$_POST['amount'],
        'percent' => (float)$_POST['percent'],
        'display' => (int)$_POST['display'],
        'item_id' => (int)$_POST['item_id'],
        'update_time' => time()
      ), 
      array('id'=>$gift['id'])
    );

    logAdmin('Cập nhật phần thưởng ['.$gift['name'].'] trong vòng quay');
  }

  
  /* Delete Wheel Gift */
  public function deleteWheelGift () {
    $gift = $this->getWheelGift($_POST['wheel_gift_id']);

    (new _PDO())->delete(self::$PDO_DeleteWheelGift, array('id' => $gift['id']));
    logAdmin('Xóa phần thưởng vòng quay ID ['.$gift['id'].']');
  }
}