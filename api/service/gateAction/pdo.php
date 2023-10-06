<?php
class GatePDO {
  static $PDO_GetAllGate = "SELECT * FROM ny_gate WHERE display='1' ORDER BY update_time DESC";
  static $PDO_GetGate = "SELECT * FROM ny_gate WHERE display='1' AND id=:id";
}