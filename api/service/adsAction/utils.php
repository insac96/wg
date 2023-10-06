<?php
require 'pdo.php';

class AdsUtils extends AdsPDO {
  /* Get Ads By ID */
  public function getAds ($id) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID nguồn biết đến trò chơi');

    $ads = (new _PDO())->select(self::$PDO_GetAds, array('id' => $id));
    if(empty($ads)) return res(400, 'Nguồn biết đến trò chơi không tồn tại');
    return $ads;
  }
}