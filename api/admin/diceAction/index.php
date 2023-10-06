<?php
require 'utils.php';

class Dice extends DiceUtils {
  /* Get Dice Config */
  public function getDiceConfig () {
    $config = (new _PDO())->select(self::$PDO_GetDiceConfig, []);
    return $config;
  }

  /* Update Dice */
  public function updateDiceConfig () {
    if(
      !is_numeric($_POST['default_jar'])
      || !is_numeric($_POST['need_vip'])
      || !is_numeric($_POST['percent_jar_six'])
      || !is_float((float)$_POST['percent_jar_other'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Gift And Percent
    if((int)$_POST['default_jar'] <= 0)
      res(400, 'Số xu hũ mặc định phải lớn hơn 0');
    if((int)$_POST['percent_jar_six'] < 0 || $_POST['percent_jar_other'] < 0)
      res(400, 'Tỷ lệ phải lơn hơn hoặc bằng 0');
    if((int)$_POST['percent_jar_six'] > 10 || $_POST['percent_jar_other'] > 10)
      res(400, 'Tỷ lệ phải nhỏ hơn hoặc bằng 10');

    // Update
    (new _PDO())->update('ny_dice', 
      array(
        'default_jar' => (int)$_POST['default_jar'],
        'percent_jar_six' => (int)$_POST['percent_jar_six'],
        'percent_jar_other' => (int)$_POST['percent_jar_other'],
        'need_vip' => (int)$_POST['need_vip'],
      ), 
      array('1'=>1)
    );

    logAdmin('Cập nhật cài đặt xúc xắc');
  }
}