<?php
class MissionPDO {
  static $PDO_GetAllMission = "SELECT * FROM ny_mission WHERE display='1' ORDER BY update_time DESC";
  static $PDO_GetMission = "SELECT * FROM ny_mission WHERE display='1' AND id=:id";
  static $PDO_GetLogMission = "SELECT * FROM ny_log_mission WHERE mission_id=:mission_id AND account=:account";
}