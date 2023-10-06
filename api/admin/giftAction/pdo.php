<?php
class GiftPDO {
  static $PDO_GetAllGift = "SELECT * FROM ny_gift";
  static $PDO_GetGift = "SELECT * FROM ny_gift WHERE id=:id";
  static $PDO_DeleteGift = "DELETE FROM ny_gift WHERE id=:id";
}