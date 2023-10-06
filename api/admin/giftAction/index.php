<?php
require 'utils.php';

class Gift extends GiftUtils {
  /* Get All Gift */
  public function getAllGift ($select = false) {
    if($select) return (new _PDO())->select(self::$PDO_GetAllGift, [], true);
    return getTableList('ny_gift', self::$PDO_GetAllGift);
  }

  /* Update Gift */
  public function updateGift () {
    if(
      empty($_POST['name'])
      || empty($_POST['list'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Gift
    $gift = $this->getGift($_POST['id']);

    // Update
    (new _PDO())->update('ny_gift',
      array(
        'name' => (string)$_POST['name'],
        'list' => (string)$_POST['list'],
      ),
      array('id' => $gift['id'])
    );

    // Log
    logAdmin('Cập nhật bộ quà tặng ['.$gift['name'].']');
  }

  /* Create Gift */
  public function createGift () {
    if(
      empty($_POST['name'])
      || empty($_POST['list'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Create
    (new _PDO())->create('ny_gift', array(
      'name' => (string)$_POST['name'],
      'list' => (string)$_POST['list'],
    ));

    logAdmin('Tạo bộ quà tặng ['.$_POST['name'].']');
  }

  /* Delete Gift */
  public function deleteGift () {
    $gift = $this->getGift($_POST['gift_id']);

    (new _PDO())->delete(self::$PDO_DeleteGift, array('id' => $gift['id']));
    logAdmin('Xóa bộ quà tặng ['.$gift['name'].']');
  }
}