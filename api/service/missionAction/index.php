<?php
require 'utils.php';

class Mission extends MissionUtils {
  /* Get All Mission */
  public function getAllMission () {
    $list = (new _PDO())->select(self::$PDO_GetAllMission, [], true);

    // Check Is Login
    $authModel = new Auth();
    $user = $authModel->isLogin() ? $authModel->getAuth() : null;

    for ($i=0; $i < count($list); $i++) { 
      $mission = $list[$i];
      $list[$i]['active'] = $this->getActive($user, $mission);
    }

    return $list;
  }

  /* Receive Mission */
  public function receiveMission ($user) {
    // Check Data
    if(!is_numeric($_POST['mission_id']) || empty($_POST['server_id']))
      res(400, 'Dữ liệu đầu vào sai');

    // Check Mission
    $mission = $this->getMission($_POST['mission_id']);

    // Check Active
    $active = $this->getActive($user, $mission);
    if((int)$active['type'] != 2) 
      res(400, $active['msg']);

    // Send Item To Game
    $items = (array)json_decode($mission['gifts']);
    (new Game())->sendItems($user['account'], array(
      'server_id' => $_POST['server_id'],
      'items' => $items
    ));

    // Save Log
    (new _PDO())->create('ny_log_mission', array(
      'account' => (string)$user['account'],
      'server_id' => (string)$_POST['server_id'],
      'mission_id' => (int)$mission['id'],
      'action' => 'Đã nhận thưởng nhiệm vụ ['.$mission['name'].'] tại máy chủ ['.$_POST['server_id'].']',
      'create_time' => time()
    ));
  }
}