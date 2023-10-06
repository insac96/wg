<?php
require 'utils.php';

class Vip extends VipUtils {
  /* Get All Vip */
  public function getAllVip () {
    return getTableList('ny_vip', self::$PDO_GetAllVip);
  }

  public function updateVip () {
    if(
      !is_numeric($_POST['need_exp']) 
      || !is_numeric($_POST['discount_shop']) 
      || !is_numeric($_POST['pay_bonus']) 
      || !is_numeric($_POST['referral_pay_bonus']) 
      || !is_numeric($_POST['referral_bonus_coin']) 
      || !is_numeric($_POST['pay_to_wheel'])
      || !is_numeric($_POST['diamond_to_money'])
      || !is_numeric($_POST['max_invite'])
      || !is_numeric($_POST['max_spin_wheel'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Get VIP
    $vip = $this->getVip($_POST['number']);

    // Update
    (new _PDO())->update('ny_vip',
      array(
        'need_exp' => (int)$_POST['need_exp'],
        'discount_shop' => (int)$_POST['discount_shop'],
        'pay_bonus' => (int)$_POST['pay_bonus'],
        'referral_pay_bonus' => (int)$_POST['referral_pay_bonus'],
        'referral_bonus_coin' => (int)$_POST['referral_bonus_coin'],
        'pay_to_wheel' => (int)$_POST['pay_to_wheel'],
        'diamond_to_money' => (int)$_POST['diamond_to_money'],
        'max_invite' => (int)$_POST['max_invite'],
        'max_spin_wheel' => (int)$_POST['max_spin_wheel'],
      ),
      array(
        'number' => $vip['number']
      )
    );

    // Log
    logAdmin('Cập nhật cấp VIP ['.$vip['number'].']');
  }
}