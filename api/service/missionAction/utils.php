<?php
require 'pdo.php';

class MissionUtils extends MissionPDO {
  /* Return Active */
  public function returnActive ($text, $type, $msg = null) {
    return array(
      'text' => $text,
      'type' => $type,
      'msg' => $msg
    );
  }

  /* Get Active */
  public function getActive ($user, $mission){
    if(empty($user)) return $this->returnActive('Chưa đăng nhập', -1, 'Yêu cầu đăng nhập trước');

    // Check Expires
    if(isExpires($mission['expires_time']))
      return $this->returnActive('Hết hạn', 0, 'Nhiệm vụ đã hết thời gian hiệu lực');

    // Check Items
    $items = (array)json_decode($mission['gifts']);
    if(count($items) == 0)
      return $this->returnActive('Chưa khả dụng', 0, 'Nhiệm vụ chưa cập nhật phần thưởng, vui lòng quay lại sau');

    // Check Log
    $account = $user['account'];
    $mission_id = $mission['id'];
    $log = (new _PDO())->select(self::$PDO_GetLogMission, array(
      'mission_id' => $mission_id,
      'account' => $account
    ));
    if(!empty($log))
      return $this->returnActive('Đã nhận', 3, 'Bạn đã nhận thưởng nhiệm vụ này rồi');

    // Check Account With Mission Type
    $type = $mission['type'];
    $need = $mission['need'];

    if($type == 'vip'){
      $check = $user[$type]['number'];
    }
    else {
      $check = $user[$type];
    }
    
    if(!isset($check))
      return $this->returnActive('Lỗi', 0, 'Nhiệm vụ đang bị lỗi, vui lòng quay lại sau');
    if((int)$check < (int)$need)
      return $this->returnActive('Chưa đạt', 1, 'Bạn chưa hoàn thành nhiệm vụ');

    // Active
    return $this->returnActive('Có thể nhận', 2);
  }

  /* Get Mission  */
  public function getMission ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $mission = (new _PDO())->select(self::$PDO_GetMission, array('id' => $id));

    if(empty($mission)) return res(400, 'Nhiệm vụ không tồn tại');
    return $mission;
  }
}
