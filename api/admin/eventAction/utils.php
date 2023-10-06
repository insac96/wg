<?php
require 'pdo.php';

class EventUtils extends EventPDO {
  /* Get Event  */
  public function getEvent ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $event = (new _PDO())->select(self::$PDO_GetEvent, array('id' => $id));

    if(empty($event)) return res(400, 'Sự kiện không tồn tại');
    return $event;
  }

  /* Has Event By Type */
  public function hasEventByType ($type) {
    $event = (new _PDO())->select(self::$PDO_GetEventByType, array('type' => $type));

    if(empty($event)) return false;
    return true;
  }

  /* Get Milestone */
  public function getEventMilestone ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $milestone = (new _PDO())->select(self::$PDO_GetEventMilestone, array('id' => $id));

    if(empty($milestone)) return res(400, 'Mốc thưởng không tồn tại');
    return $milestone;
  }

  /* Has Milestone By Need */
  public function hasEventMilestoneByNeed ($need, $event_id) {
    $milestone = (new _PDO())->select(self::$PDO_GetEventMilestoneByNeed, array(
      'need' => $need,
      'event_id' => $event_id
    ));

    if(empty($milestone)) return false;
    return true;
  }
}