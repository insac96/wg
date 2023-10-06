<?php
class MissionPDO {
  static $PDO_GetAllMission = "SELECT * FROM ny_mission";
  static $PDO_GetMission = "SELECT * FROM ny_mission WHERE id=:id";
  static $PDO_DeleteMission = "DELETE FROM ny_mission WHERE id=:id";
}