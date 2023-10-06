<?php
require 'utils.php';

class Event extends EventUtils {
  /* Get All Event */
  public function getAllEvent () {
    return getTableList('ny_event', self::$PDO_GetAllEvent);
  }

  /* Create Event */
  public function createEvent () {
    if(
      empty($_POST['name'])
      || empty($_POST['type'])
      || empty($_POST['milestone_type'])
      || empty($_POST['comparison'])
      || empty($_POST['expires_time'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check Event Type
    if($this->hasEventByType($_POST['type']))
      res(400, 'Loại sự kiện đã tồn tại');

    // Make Expires
    $expires_time = makeExpires($_POST['expires_time']['date'], $_POST['expires_time']['time']);

    // Create
    (new _PDO())->create('ny_event', array(
      'name' => (string)$_POST['name'],
      'info' => (string)$_POST['info'],
      'type' => (string)$_POST['type'],
      'milestone_type' => (string)$_POST['milestone_type'],
      'comparison' => (string)$_POST['comparison'],
      'expires_time' => (int)$expires_time,
      'prefix' => (string)$_POST['prefix'],
      'suffix' => (string)$_POST['suffix'],
      'display' => (int)$_POST['display'],
      'update_time' => time()
    ));

    logAdmin('Tạo sự kiện ['.$_POST['name'].']');
  }

  /* Update Event */
  public function updateEvent () {
    if(
      empty($_POST['name'])
      || empty($_POST['type'])
      || empty($_POST['milestone_type'])
      || empty($_POST['comparison'])
      || empty($_POST['expires_time'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Event
    $event = $this->getEvent($_POST['id']);

    // Check New Type
    if($event['type'] != $_POST['type'])
      if($this->hasEventByType($_POST['type']))
        res(400, 'Loại sự kiện đã tồn tại');

    // Make Expires
    $expires_time = makeExpires($_POST['expires_time']['date'], $_POST['expires_time']['time']);

    // Update
    (new _PDO())->update('ny_event',
      array(
        'name' => (string)$_POST['name'],
        'info' => (string)$_POST['info'],
        'type' => (string)$_POST['type'],
        'milestone_type' => (string)$_POST['milestone_type'],
        'comparison' => (string)$_POST['comparison'],
        'expires_time' => (int)$expires_time,
        'prefix' => (string)$_POST['prefix'],
        'suffix' => (string)$_POST['suffix'],
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array('id' => $event['id'])
    );

    // Log
    logAdmin('Cập nhật sự kiện ['.$event['name'].']');
  }

  /* Delete Event */
  public function deleteEvent () {
    $event = $this->getEvent($_POST['event_id']);

    (new _PDO())->delete(self::$PDO_DeleteEvent, array('id' => $event['id']));
    (new _PDO())->delete(self::$PDO_DeleteMilestoneOfEvent, array('event_id' => $event['id']));
    logAdmin('Xóa sự kiện ['.$event['name'].']');
  }

  /* Get All Event Milestone */
  public function getAllEventMilestone () {
    if(empty($_POST['event_id'])) return res('Không tìm thấy ID sự kiện');

    $event_id = $_POST['event_id'];
    $sqlCount = "SELECT id FROM ny_event_milestone WHERE event_id=:event_id";
    $countQuery = (new _PDO())->select($sqlCount, array('event_id' => $event_id), true);
    $count = count($countQuery);
    $sql = "SELECT * FROM ny_event_milestone WHERE event_id = $event_id";

    return getTableList(null, $sql, $count);
  }

  /* Create Event Milestone */
  public function createEventMilestone () {
    if(!is_numeric($_POST['event_id']) || !is_numeric($_POST['need']) || empty($_POST['gifts']))
      res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check Event
    $event = $this->getEvent($_POST['event_id']);

    // Check Need
    if((int)$_POST['need'] < 1) 
      res(400, 'Điều kiện mốc thưởng phải lớn hơn 0');
    if($this->hasEventMilestoneByNeed($_POST['need'], $event['id']))
      res(400, 'Điều kiện mốc thưởng đã tồn tại');

    // Check Gift
    $gifts = (array)json_decode((string)$_POST['gifts']);
    if(!is_array($gifts))
      res(400, 'Phần thưởng đưa vào không hợp lệ');

    // Create
    (new _PDO())->create('ny_event_milestone', array(
      'event_id' => (int)$_POST['event_id'],
      'need' => (int)$_POST['need'],
      'gifts' => (string)$_POST['gifts']
    ));

    // Log
    logAdmin('Tạo mốc thưởng cho sự kiện ['.$event['name'].']');
  }

  /* Update Event Milestone */
  public function updateEventMilestone () {
    if(!is_numeric($_POST['event_id']) || !is_numeric($_POST['need']))
      res(400, 'Dữ liệu đầu vào không đủ');

    // Check Event and Milestone
    $milestone = $this->getEventMilestone($_POST['id']);
    $event = $this->getEvent($_POST['event_id']);

    // Check Need
    if((int)$_POST['need'] < 1) 
      res(400, 'Điều kiện mốc thưởng phải lớn hơn 0');
    if($milestone['need'] != $_POST['need'])
      if($this->hasEventMilestoneByNeed($_POST['need'], $event['id']))
        res(400, 'Điều kiện mốc thưởng đã tồn tại');

    // Check Gift
    $gifts = (array)json_decode((string)$_POST['gifts']);
    if(!is_array($gifts))
      res(400, 'Phần thưởng đưa vào không hợp lệ');

    // Update
    (new _PDO())->update('ny_event_milestone', 
      array(
        'need' => (int)$_POST['need'],
        'gifts' => (string)$_POST['gifts']
      ),
      array('id' => $milestone['id'])
    );

    // Log
    logAdmin('Cập nhật mốc thưởng ['.$milestone['need'].'] của sự kiện ['.$event['name'].']');
  }

  /* Delete Event Milestone */
  public function deleteEventMilestone () {
    $milestone = $this->getEventMilestone($_POST['milestone_id']);
    $event = $this->getEvent($milestone['event_id']);

    (new _PDO())->delete(self::$PDO_DeleteEventMilestone, array('id' => $milestone['id']));
    logAdmin('Xóa mốc thưởng ['.$milestone['need'].'] của sự kiện ['.$event['name'].']');
  }
}