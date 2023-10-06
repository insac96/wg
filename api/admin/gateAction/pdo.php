<?php
class GatePDO {
  static $PDO_GetAllGate = "SELECT * FROM ny_gate";
  static $PDO_GetGate = "SELECT * FROM ny_gate WHERE id=:id";
}