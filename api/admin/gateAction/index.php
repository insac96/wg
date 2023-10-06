<?php
require 'utils.php';

class Gate extends GateUtils {
  /* Get All Gate */
  public function getAllGate () {
    return getTableList('ny_gate', self::$PDO_GetAllGate);
  }

  /* Update Gate */
  public function updateGate () {
    if(
      empty($_POST['name']) 
      || !is_numeric($_POST['type']) 
      || empty($_POST['person']) 
      || empty($_POST['stk'])
      || !is_numeric($_POST['bonus_default'])
      || !is_numeric($_POST['bonus'])
      || empty($_POST['expires_bonus'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Gate
    $gate = $this->getGate($_POST['id']);

    // Make Expires
    $expires_time = makeExpires($_POST['expires_bonus']['date'], $_POST['expires_bonus']['time']);
    if($_POST['bonus'] == 0) {
      $expires_time = 0;
    }

    // Update
    (new _PDO())->update('ny_gate',
      array(
        'type' => (int)$_POST['type'],
        'name' => (string)$_POST['name'],
        'person' => (string)$_POST['person'],
        'stk' => (string)$_POST['stk'],
        'icon' => (string)$_POST['icon'],
        'qr_link' => (string)$_POST['qr_link'],
        'bonus_default' => (int)$_POST['bonus_default'],
        'bonus' => (int)$_POST['bonus'],
        'expires_bonus' => (int)$expires_time,
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array(
        'id' => $gate['id']
      )
    );

    // Log
    logAdmin('Cập nhật kênh thanh toán ['.$gate['name'].']');
  }
}