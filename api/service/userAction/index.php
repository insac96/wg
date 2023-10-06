<?php
require 'utils.php';

class User extends UserUtils {
  /* Get All User Effect */
  public function getAllUserEffect ($user) {
    $sql = "SELECT effect.id, effect.name, effect.type 
      FROM ny_log_shop log
      LEFT JOIN ny_shop_effect effect ON effect.id = log.shop_id
      WHERE log.account=:account
      AND log.shop_type=:shop_type
    ";

    $list = (new _PDO())->select($sql, array(
      'account' => $user['account'],
      'shop_type' => 'effect'
    ), true);

    return $list;
  }

  /* Update User Effect */
  public function updateUserEffect ($user) {
    if(empty($_POST['effect_type'])) return res(400, 'Dữ liệu đầu vào sai');

    if($_POST['effect_type'] != 'vip'){
      // Check Effect
      $effect = (new Shop())->getEffectByType($_POST['effect_type']);

      // Check Buy
      $countBuy = (new Shop())->getCountBuyEffect($user['account'], $effect['id']);
      if($countBuy < 1) return res(400, 'Bạn chưa mua hiệu ứng này');

      // Update
      $this->updateUser($user['account'], array(
        'effect' => $effect['type']
      ));
    }
    else {
      $this->updateUser($user['account'], array(
        'effect' => 'vip'
      ));
    }
  }
}