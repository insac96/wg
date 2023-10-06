<?php
require 'pdo.php';

class ShopUtils extends ShopPDO {
  /* Get Recharge By ID */
  public function getRecharge ($id) {
    $recharge = (new _PDO())->select(self::$PDO_GetRecharge, array('id' => (int)$id));
    if(empty($recharge)) return res(400, 'Gói không tồn tại');
    return $recharge;
  }

  /* Get Count Buy Recharge */
  public function getCountBuyRecharge ($account, $recharge_id, $server_id){
    $sql = "SELECT id 
      FROM ny_log_shop
      WHERE account=:account
      AND shop_type=:shop_type
      AND shop_id=:shop_id
      AND server_id=:server_id
    ";

    $log = (new _PDO())->select($sql, array(
      'account' => $account,
      'shop_id' => $recharge_id,
      'server_id' => $server_id,
      'shop_type' => 'recharge'
    ), true);

    return count($log);
  }

  /* Get Item By ID */
  public function getItem ($id) {
    $item = (new _PDO())->select(self::$PDO_GetItem, array('id' => (int)$id));
    if(empty($item)) return res(400, 'Vật phẩm không tồn tại');
    return $item;
  }

  /* Get Currency By ID */
  public function getCurrency ($id) {
    $currency = (new _PDO())->select(self::$PDO_GetCurrency, array('id' => (int)$id));
    if(empty($currency)) return res(400, 'Loại tiền tệ không tồn tại');
    return $currency;
  }

  /* Get Effect By ID */
  public function getEffect ($id) {
    $effect = (new _PDO())->select(self::$PDO_GetEffect, array('id' => (int)$id));
    if(empty($effect)) return res(400, 'Hiệu ứng không tồn tại');
    return $effect;
  }

  /* Get Effect By Type */
  public function getEffectByType ($type) {
    $effect = (new _PDO())->select(self::$PDO_GetEffectByType, array('type' => (string)$type));
    if(empty($effect)) return res(400, 'Hiệu ứng không tồn tại');
    return $effect;
  }

  /* Get Count Buy Effect */
  public function getCountBuyEffect ($account, $effect_id){
    $sql = "SELECT id 
      FROM ny_log_shop
      WHERE account=:account
      AND shop_type=:shop_type
      AND shop_id=:shop_id
    ";

    $log = (new _PDO())->select($sql, array(
      'account' => $account,
      'shop_id' => $effect_id,
      'shop_type' => 'effect'
    ), true);

    return count($log);
  }

  /* Check Coin */
  public function checkCoin ($user, $need) {
    $coin_total = (int)$user['coin'] + (int)$user['coin_lock'];
    if((int)$coin_total < (int)$need) return res(400, 'Số dư Xu không đủ');
  }

  /* Update User Coin */
  public function updateUserCoin ($user, $need) {
    $coin = (int)$user['coin'];
    $coin_lock = (int)$user['coin_lock'];
    $coin_minus = (int)$coin_lock - (int)$need;

    if((int)$coin_minus < 0){
      $coin = (int)$coin + (int)$coin_minus;
      $coin_lock = 0;
    }
    else {
      $coin_lock = (int)$coin_minus;
    }

    (new User())->updateUser($user['account'], array(
      'coin' => $coin,
      'coin_lock' => $coin_lock,
      'spend_day' => array('+', (int)$need),
      'spend_month' => array('+', (int)$need),
      'spend_all' => array('+', (int)$need),
    ));
  }
}