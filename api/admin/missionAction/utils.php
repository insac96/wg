<?php
require 'pdo.php';

class MissionUtils extends MissionPDO {
  /* Get Mission  */
  public function getMission ($id) {
    if(!is_numeric($id)) return res(400, 'Dữ liệu đầu vào sai');

    $mission = (new _PDO())->select(self::$PDO_GetMission, array('id' => $id));

    if(empty($mission)) return res(400, 'Nhiệm vụ không tồn tại');
    return $mission;
  }
}