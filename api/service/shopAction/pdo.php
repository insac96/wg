<?php
class ShopPDO {
  static $PDO_GetShopRecharge = "SELECT *, display as active FROM ny_shop_recharge WHERE display='1' ORDER BY update_time DESC LIMIT :start, :limit";
  static $PDO_GetRecharge = "SELECT * FROM ny_shop_recharge WHERE display='1' AND id=:id";
  
  static $PDO_GetShopItem = "SELECT * FROM ny_shop_item WHERE display='1' ORDER BY update_time DESC";
  static $PDO_GetItem = "SELECT * FROM ny_shop_item WHERE display='1' AND id=:id";

  static $PDO_GetShopCurrency = "SELECT * FROM ny_shop_currency WHERE display='1' ORDER BY update_time DESC";
  static $PDO_GetCurrency = "SELECT * FROM ny_shop_currency WHERE display='1' AND id=:id";

  static $PDO_GetShopEffect = "SELECT * FROM ny_shop_effect WHERE display='1' ORDER BY update_time DESC";
  static $PDO_GetEffect = "SELECT * FROM ny_shop_effect WHERE display='1' AND id=:id";
  static $PDO_GetEffectByType = "SELECT * FROM ny_shop_effect WHERE display='1' AND type=:type";
}