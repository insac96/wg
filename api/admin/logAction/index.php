<?php
require 'utils.php';

class Log extends LogUtils {
  /* Search Log */
  public function searchLog () {
    if(empty($_POST['type'])) return res(400, 'Thiếu dữ liệu đầu vào');
      
    $typeLog = $_POST['type'];
    
    if($typeLog == 'admin') return $this->searchLogAdmin();
    if($typeLog == 'shop') return $this->searchLogShop();
    if($typeLog == 'event') return $this->searchLogEvent();
    if($typeLog == 'mission') return $this->searchLogMission();
    if($typeLog == 'wheel') return $this->searchLogWheel();
    if($typeLog == 'dice') return $this->searchLogDice();
    if($typeLog == 'giftcode') return $this->searchLogGiftcode();
    
    res(400, 'Loại tìm kiếm không hỗ trợ');
  }

  /* Get All Log Admin */
  public function getAllLogAdmin () {
    return getTableList('ny_log_admin', self::$PDO_GetAllLogAdmin);
  }

  /* Get All Log Shop */
  public function getAllLogShop () {
    return getTableList('ny_log_shop', self::$PDO_GetAllLogShop);
  }

  /* Get All Log Event */
  public function getAllLogEvent () {
    return getTableList('ny_log_event', self::$PDO_GetAllLogEvent);
  }

  /* Get All Log Mission */
  public function getAllLogMission () {
    return getTableList('ny_log_mission', self::$PDO_GetAllLogMission);
  }

  /* Get All Log Wheel */
  public function getAllLogWheel () {
    return getTableList('ny_log_wheel', self::$PDO_GetAllLogWheel);
  }

  /* Get All Log Wheel */
  public function getAllLogDice () {
    return getTableList('ny_log_dice', self::$PDO_GetAllLogDice);
  }

  /* Get All Log Giftcode */
  public function getAllLogGiftcode () {
    return getTableList('ny_log_giftcode', self::$PDO_GetAllLogGiftcode);
  }
}