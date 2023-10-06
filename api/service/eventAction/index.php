<?php
require 'utils.php';

class Event extends EventUtils {
  /* Get All Event */
  public function getAllEvent () {
    $list = (new _PDO())->select(self::$PDO_GetAllEvent, [], true);
    return $list;
  }

  /* Get All Milestone View*/
  public function getAllMilestone () {
    // Check Event
    $event = $this->getEvent($_POST['event_id']);

    // Check Is Login
    $authModel = new Auth();
    $user = $authModel->isLogin() ? $authModel->getAuth() : null;

    // Set Active
    $list = (new _PDO())->select(self::$PDO_GetAllMilestone, array('event_id'=>$event['id']), true);
    for ($i=0; $i < count($list); $i++) { 
      $milestone = $list[$i];
      $list[$i]['active'] = $this->getActive($user, $event, $milestone);
    }

    // Return
    return $list;
  }

  /* Receive Milestone */
  public function receiveMilestone ($user) {
    // Check Data
    if(!is_numeric($_POST['milestone_id']) || empty($_POST['server_id']))
      res(400, 'Dữ liệu đầu vào sai');

    // Get Event and Milestone
    $milestone = $this->getMilestone($_POST['milestone_id']);
    $event = $this->getEvent($milestone['event_id']);

    // Check Active
    $active = $this->getActive($user, $event, $milestone);
    if((int)$active['type'] != 2) 
      res(400, $active['msg']);

    // Send Items To Game
    $items = (array)json_decode($milestone['gifts']);
    (new Game())->sendItems($user['account'], array(
      'server_id' => $_POST['server_id'],
      'items' => $items
    ));

    // Save Log
    (new _PDO())->create('ny_log_event', array(
      'account' => (string)$user['account'],
      'server_id' => (string)$_POST['server_id'],
      'event_id' => (int)$event['id'],
      'milestone_id' => (int)$milestone['id'],
      'action' => 'Đã nhận mốc thưởng ['.$event['prefix'].' '.$milestone['need'].' '.$event['suffix'].'] của sự kiện ['.$event['name'].'] tại máy chủ ['.$_POST['server_id'].']',
      'create_time' => time()
    ));
  }
}