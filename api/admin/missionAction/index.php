<?php
require 'utils.php';

class Mission extends MissionUtils {
  /* Get All Mission */
  public function getAllMission () {
    return getTableList('ny_mission', self::$PDO_GetAllMission);
  }

  /* Update Mission */
  public function updateMission () {
    if(
      empty($_POST['name'])
      || empty($_POST['info'])
      || empty($_POST['type'])
      || empty($_POST['gifts'])
      || empty($_POST['expires_time'])
      || !is_numeric($_POST['need'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Mission
    $mission = $this->getMission($_POST['id']);

    // Check Need
    if((int)$_POST['need'] < 1) 
      res(400, 'Điều kiện mốc thưởng phải lớn hơn 0');

    // Make Expires
    $expires_time = makeExpires($_POST['expires_time']['date'], $_POST['expires_time']['time']);

    // Update
    (new _PDO())->update('ny_mission',
      array(
        'name' => (string)$_POST['name'],
        'info' => (string)$_POST['info'],
        'need' => (int)$_POST['need'],
        'type' => (string)$_POST['type'],
        'gifts' => (string)$_POST['gifts'],
        'expires_time' => (int)$expires_time,
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array('id' => $mission['id'])
    );

    // Log
    logAdmin('Cập nhật nhiệm vụ ['.$mission['name'].']');
  }

  /* Create Mission */
  public function createMission () {
    if(
      empty($_POST['name'])
      || empty($_POST['info'])
      || empty($_POST['type'])
      || empty($_POST['gifts'])
      || empty($_POST['expires_time'])
      || !is_numeric($_POST['need'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Need
    if((int)$_POST['need'] < 1) 
      res(400, 'Điều kiện mốc thưởng phải lớn hơn 0');

    // Make Expires
    $expires_time = makeExpires($_POST['expires_time']['date'], $_POST['expires_time']['time']);

    // Create
    (new _PDO())->create('ny_mission', array(
      'name' => (string)$_POST['name'],
      'info' => (string)$_POST['info'],
      'need' => (int)$_POST['need'],
      'type' => (string)$_POST['type'],
      'gifts' => (string)$_POST['gifts'],
      'expires_time' => (int)$expires_time,
      'display' => (int)$_POST['display'],
      'update_time' => time()
    ));

    logAdmin('Tạo nhiệm vụ ['.$_POST['name'].']');
  }

  /* Delete Mission */
  public function deleteMission () {
    $mission = $this->getMission($_POST['mission_id']);

    (new _PDO())->delete(self::$PDO_DeleteMission, array('id' => $mission['id']));
    logAdmin('Xóa nhiệm vụ ['.$mission['name'].']');
  }
}