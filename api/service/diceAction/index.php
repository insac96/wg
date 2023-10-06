<?php
require 'utils.php';

class Dice extends DiceUtils {
  // get Dice
  public function getDice () {
    $config = $this->getDiceConfig();
    $logs = $this->getAllDiceLog();
    $world = $this->getAllDiceLogWorld();

    if((int)$config['jar'] < (int)$config['default_jar']){
      $jar = $config['default_jar'];
      $this->updateJarDice();
    }
    else {
      $jar = $config['jar'];
    }

    return array(
      'jar' => $jar,
      'logs' => $logs,
      'world' => $world
    );
  }

  /* Shock Dice */
  public function shockDice ($user) {
    if(empty($_POST['dice_list']) || !is_array($_POST['dice_list'])) return res(400, 'Dữ liệu đầu vào sai');
    
    // Check Dices 
    $dice_list = (array)$_POST['dice_list'];
    if(!array_key_exists(1, $dice_list)
      || !array_key_exists(2, $dice_list)
      || !array_key_exists(3, $dice_list)
      || !array_key_exists(4, $dice_list)
      || !array_key_exists(5, $dice_list)
      || !array_key_exists(6, $dice_list)
    ) return res(400, 'Dữ liệu đầu vào sai');

    // Get Config
    $config = $this->getDiceConfig();

    // Check VIP User
    if((int)$user['vip']['number'] < (int)$config['need_vip']) return res(400, 'VIP '.$config['need_vip'].' mới có thể chơi');
    
    // Check Money Total
    $money_total = 0;
    foreach ($dice_list as $key => $value) {
      if(!is_numeric($value) || (int)$value < 0) return res(400, 'Dữ liệu đầu vào sai');
      $money_total = (int)$money_total + (int)$value;
    }
    if(!is_numeric($money_total) || (int)$money_total <= 0) return res(400, 'Vui lòng chọn lại số tiền chơi');
    
    // Check Coin Play
    $coin_total = (int)$user['coin'] + (int)$user['coin_lock'];
    if((int)$coin_total < (int)$money_total) return res(400, 'Số dư Xu không đủ');

    // Make Dice Result
    $money = 0;
    $dices_result = $this->getRandomDices($config);

    // Make Money Add
    $money_add = 0;
    foreach ($dices_result as $dice) {
      $money_add = (int)$money_add + ((int)$dice_list[$dice] * 2);
    }
    $money_add = floor((int)$money_add * 90 / 100);
    $money = (int)$money_add - (int)$money_total;

    // Make Action
    if($this->isJarSix($dices_result)){
      $money_jar = (int)$config['jar'];
      $jar_add = null;
      $action = 'Nổ hũ ['.$money_jar.' Xu]';
    }
    else if($this->isJarOther($dices_result)){
      $money_jar = floor((int)$config['jar'] * 10 / 100);
      $jar_add = (int)$money_jar * -1;
      $action = 'Nổ hũ 10% ['.$money_jar.' Xu]';
    } 
    else {
      $money_jar = 0;
      if($money < 0){
        $jar_add = (int)$money * -1;
        $action = 'Đặt ['.$money_total.' Xu] thua ['.$money.' Xu]';
      }
      else {
        $jar_add = 0;
        $action = 'Đặt ['.$money_total.' Xu] thắng ['.$money.' Xu]';
      }
    }

    // Update Jar Dice
    $this->updateJarDice($jar_add);

    // Update User Coin
    $coin_update = (int)$money + (int)$money_jar;
    $this->updateUserCoin($user, $coin_update);

    // Write Log
    (new _PDO())->create('ny_log_dice', array(
      'account' => (string)$user['account'],
      'action' => (string)$action,
      'money' => (int)$coin_update,
      'create_time' => time()
    ));

    // Return
    return array(
      'money_jar' => $money_jar,
      'money_minus' => $money_total,
      'money_add' => $money_add,
      'dices' => $dices_result
    );
  }
}