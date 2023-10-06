<?php
class GiftcodePDO {
  static $PDO_GetAllGiftcode = "SELECT * FROM ny_giftcode";
  static $PDO_GetGiftcode = "SELECT * FROM ny_giftcode WHERE id=:id";
  static $PDO_GetGiftcodeByName = "SELECT * FROM ny_giftcode WHERE name=:name";
  static $PDO_DeleteGiftcode = "DELETE FROM ny_giftcode WHERE id=:id";
}