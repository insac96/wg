<?php
require 'pdo.php';
class DiceUtils extends DicePDO {
  /* Get Dice */
  public function getDiceConfig () {
    $config = (new _PDO())->select(self::$PDO_GetDiceConfig, []);
    if(empty($config)) return res(400, 'Không tìm thấy cài đặt xúc xắc');
    return $config;
  }

  /* Get All Dice Log */
  public function getAllDiceLog () {
    $authModel = new Auth();
    $user = $authModel->isLogin() ? $authModel->getAuth() : null;
    if(empty($user)) return null;
    
    $logs = (new _PDO())->select(self::$PDO_GetAllDiceLog, array('account' => $user['account']), true);
    return $logs;
  }

  /* Get All Dice Log World */
  public function getAllDiceLogWorld () {
    $list = (new _PDO())->select(self::$PDO_GetAllDiceLogWorld, [], true);
    return $list;
  }

  /* Update Jar Dice */
  public function updateJarDice ($money = null) {
    $config = $this->getDiceConfig();

    if(!isset($money)){
      $jar = $config['default_jar'];
    }
    else {
      $jar = (int)$config['jar'] + (int)$money;
    }

    (new _PDO())->update('ny_dice', array('jar' => (int)$jar), array(1 => 1));
  }

  /* Update User Coin */
  public function updateUserCoin ($user, $money) {
    $coin = (int)$user['coin'];
    $coin_lock = (int)$user['coin_lock'];
    $coin_minus = (int)$coin_lock + (int)$money;

    if((int)$coin_minus < 0){
      $coin = (int)$coin + (int)$coin_minus;
      $coin_lock = 0;
    }
    else {
      $coin_lock = (int)$coin_minus;
    }

    (new User())->updateUser($user['account'], array(
      'coin' => $coin,
      'coin_lock' => $coin_lock
    ));
  }

  /* Is Jar Six */
  public function isJarSix ($dices) {
    if($dices[0] == 6 && $dices[1] == 6 && $dices[2] == 6) return true;
    return false;
  }

  /* Is Jar Other */
  public function isJarOther ($dices) {
    for ($i=1; $i < 6; $i++) { 
      if($dices[0] == $i && $dices[1] == $i && $dices[2] == $i){
        return true;
      }
    }

    return false;
  }

  /* Get Random Dices */
  public function getRandomDices ($config) {
    $dices = array();
    $dices[] = rand(1,6);
    $dices[] = rand(1,6);
    $dices[] = rand(1,6);
    
    if($this->isJarSix($dices)){
      $rand = rand(1,100);
      if((int)$rand <= (int)$config['percent_jar_six']) return $dices;
      return array(rand(1,5),rand(1,5),6); 
    }

    if($this->isJarOther($dices)){
      $rand = rand(1,100);
      $dice_first = $dices[0];
      if((int)$rand <= (int)$config['percent_jar_other']) return $dices;
      return array($dice_first, 6, rand(1,5));
    }

    return $dices;
  }
}