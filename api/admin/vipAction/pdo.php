<?php
class VipPDO {
  static $PDO_GetAllVip = "SELECT * FROM ny_vip";
  static $PDO_GetVip = "SELECT * FROM ny_vip WHERE number=:number";
}