<?php
class WheelPDO {
  static $PDO_GetAllWheelGift = "SELECT * FROM ny_wheel_gift WHERE display='1' ORDER BY update_time DESC";
  static $PDO_GetWheelGift = "SELECT * FROM ny_wheel_gift WHERE id=:id and display='1'";
  static $PDO_GetLasWheelLog = "SELECT create_time FROM ny_log_wheel WHERE account=:account ORDER BY create_time DESC LIMIT 1";
  static $PDO_GetAllWheelLog = "SELECT
    log.id, log.create_time, log.action,
    gift.type as gift_type
    FROM ny_log_wheel log
    LEFT JOIN ny_wheel_gift gift
    ON log.gift_id = gift.id
    WHERE log.account=:account 
    ORDER BY log.create_time DESC
    LIMIT 5
  ";

  static $PDO_GetAllWheelLogWorld = "SELECT
    log.id, log.create_time, log.action, log.account,
    gift.type as gift_type
    FROM ny_log_wheel log
    LEFT JOIN ny_wheel_gift gift
    ON log.gift_id = gift.id
    WHERE gift.percent <= '0.01'
    ORDER BY log.create_time DESC
    LIMIT 5
  ";
}