<?php
class ShopPDO {
  static $PDO_GetAllShopRecharge = "SELECT * FROM ny_shop_recharge";
  static $PDO_GetRecharge = "SELECT * FROM ny_shop_recharge WHERE id=:id";
  static $PDO_DeleteRecharge = "DELETE FROM ny_shop_recharge WHERE id=:id";

  static $PDO_GetAllShopItem = "SELECT * FROM ny_shop_item";
  static $PDO_GetItem = "SELECT * FROM ny_shop_item WHERE id=:id";
  static $PDO_DeleteItem = "DELETE FROM ny_shop_item WHERE id=:id";

  static $PDO_GetAllShopCurrency = "SELECT * FROM ny_shop_currency";
  static $PDO_GetCurrency = "SELECT * FROM ny_shop_currency WHERE id=:id";
  static $PDO_DeleteCurrency = "DELETE FROM ny_shop_currency WHERE id=:id";

  static $PDO_GetAllShopEffect = "SELECT * FROM ny_shop_effect";
  static $PDO_GetEffect = "SELECT * FROM ny_shop_effect WHERE id=:id";
}