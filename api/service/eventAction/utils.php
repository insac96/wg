<?php
require 'pdo.php';

class EventUtils extends EventPDO {
  /* Return Actice */
  public function returnActive ($text, $type, $msg = null) {
    return array(
      'text' => $text,
      'type' => $type,
      'msg' => $msg
    );
  }

  /* Return Check Need */
  public function returnCheckNeed ($check, $need, $comparison) {
    if($comparison == '>='){
      return $check >= $need;
    }
    else if($comparison == '<='){
      return $check <= $need;
    }
    else if($comparison == '>'){
      return $check > $need;
    }
    else if($comparison == '<'){
      return $check < $need;
    }
    else if($comparison == '='){
      return $check == $need;
    }
    else {
      return false;
    }
  }

  /* Get Active */
  public function getActive ($user, $event, $milestone){
    if(empty($user)) return $this->returnActive('Chưa đăng nhập', 0, 'Vui lòng đăng nhập trước');

    // Check Items
    $items = (array)json_decode($milestone['gifts']);
    if(count($items) == 0)
      return $this->returnActive('Chưa khả dụng', 0, 'Mốc chưa cập nhật phần thưởng, vui lòng quay lại sau');
    
    // Check Expires Time
    if(isExpires($event['expires_time']))
      return $this->returnActive('Hết hạn', 0, 'Sự kiện đã hết thời gian hiệu lực');

    // Check Event Type From User
    $event_type = $event['type'];
    $check = $user[$event_type];
    if(!isset($check)) 
      return $this->returnActive('Lỗi', 0, 'Mốc thưởng của sự kiện không chính xác');

    // Get Log
    $account = $user['account'];
    $event_id = $event['id'];
    $milestone_id = $milestone['id'];
    $log = (new _PDO())->select(self::$PDO_GetLogEvent, array(
      'account' => $account,
      'event_id' => $event_id,
      'milestone_id' => $milestone_id
    ));

    // Check Log
    if(!empty($log)){
      $old_time = convertTime($log['create_time']);
      $now_time = convertTime();
      
      if($event_type == 'pay_day' || $event_type == 'spend_day'){
        if(
          $now_time['date'] <= $old_time['date'] 
          && $now_time['month'] == $old_time['month']
          && $now_time['year'] == $old_time['year']
        ) return $this->returnActive('Đã nhận', 3, 'Bạn đã nhận mốc thưởng này rồi');
      }
      else if($event_type == 'login_day' || $event_type == 'pay_month' || $event_type == 'spend_month'){
        if(
          $now_time['month'] <= $old_time['month']
          && $now_time['year'] == $old_time['year']
        ) return $this->returnActive('Đã nhận', 3, 'Bạn đã nhận mốc thưởng này rồi');
      }
      else {
        return $this->returnActive('Đã nhận', 3, 'Bạn đã nhận mốc thưởng này rồi');
      }
    }
    
    // Check Need
    $checkNeed = $this->returnCheckNeed($check, (int)$milestone['need'], $event['comparison']);
    if(!$checkNeed)
      return $this->returnActive('Chưa đạt', 1, 'Bạn chưa đủ điều kiện nhận thưởng');

    // Active
    return $this->returnActive('Nhận ngay', 2);
  }

  /* Get Milestone */
  public function getMilestone ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $milestone = (new _PDO())->select(self::$PDO_GetMilestone, array('id' => $id));

    if(empty($milestone)) return res(400, 'Mốc thưởng không tồn tại');
    return $milestone;
  }

  /* Get Event  */
  public function getEvent ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $event = (new _PDO())->select(self::$PDO_GetEvent, array('id' => $id));

    if(empty($event)) return res(400, 'Sự kiện không tồn tại');
    return $event;
  }
}