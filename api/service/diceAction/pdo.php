<?php
class DicePDO {
  static $PDO_GetDiceConfig = "SELECT * FROM ny_dice LIMIT 1";
  
  static $PDO_GetAllDiceLog = "SELECT *
    FROM ny_log_dice
    WHERE account=:account 
    ORDER BY create_time DESC
    LIMIT 5
  ";

  static $PDO_GetAllDiceLogWorld = "SELECT *
    FROM ny_log_dice
    WHERE money >= 1000000
    ORDER BY create_time DESC
    LIMIT 5
  ";
}