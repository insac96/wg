<?php
class WheelPDO {
  static $PDO_GetAllWheelGift = "SELECT * FROM ny_wheel_gift";
  static $PDO_GetWheelGift = "SELECT * FROM ny_wheel_gift WHERE id=:id";
  static $PDO_DeleteWheelGift = "DELETE FROM ny_wheel_gift WHERE id=:id";
}