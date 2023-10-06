<?php
require 'utils.php';

class Giftcode extends GiftcodeUtils {
  /* Get All Giftcode */
  public function getAllGiftcode () {
    return getTableList('ny_giftcode', self::$PDO_GetAllGiftcode);
  }

  /* Update Giftcode */
  public function updateGiftcode () {
    if(
      empty($_POST['name'])
      || empty($_POST['server_id'])
      || !is_numeric($_POST['max'])
      || empty($_POST['gifts'])
      || empty($_POST['expires_time'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Giftcode
    $giftcode = $this->getGiftcode($_POST['id']);
    if($giftcode['name'] != $_POST['name']){
      $check = $this->getGiftcodeByName($_POST['name']);
    }

    // Make Expires
    $expires_time = makeExpires($_POST['expires_time']['date'], $_POST['expires_time']['time']);

    // Update
    (new _PDO())->update('ny_giftcode',
      array(
        'name' => (string)$_POST['name'],
        'server_id' => (string)$_POST['server_id'],
        'max' => (int)$_POST['max'],
        'gifts' => (string)$_POST['gifts'],
        'expires_time' => (int)$expires_time,
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array('id' => $giftcode['id'])
    );

    // Log
    logAdmin('Cập nhật GiftCode ['.$giftcode['name'].']');
  }

  /* Create Giftcode */
  public function createGiftcode () {
    if(
      empty($_POST['name'])
      || empty($_POST['server_id'])
      || !is_numeric($_POST['max'])
      || empty($_POST['gifts'])
      || empty($_POST['expires_time'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check
    $check = $this->getGiftcodeByName($_POST['name']);

    // Make Expires
    $expires_time = makeExpires($_POST['expires_time']['date'], $_POST['expires_time']['time']);

    // Create
    (new _PDO())->create('ny_giftcode', array(
      'name' => (string)$_POST['name'],
      'server_id' => (string)$_POST['server_id'],
      'max' => (int)$_POST['max'],
      'gifts' => (string)$_POST['gifts'],
      'expires_time' => (int)$expires_time,
      'display' => (int)$_POST['display'],
      'update_time' => time()
    ));

    logAdmin('Tạo GiftCode ['.$_POST['name'].']');
  }

  /* Delete Giftcode */
  public function deleteGiftcode () {
    $giftcode = $this->getGiftcode($_POST['giftcode_id']);

    (new _PDO())->delete(self::$PDO_DeleteGiftcode, array('id' => $giftcode['id']));
    logAdmin('Xóa GiftCode ['.$giftcode['name'].']');
  }
}