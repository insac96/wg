<?php
require 'pdo.php';

class IPClientUtils extends IPClientPDO {
  /* Get IP */
  public function getIPClient ($ip) {
    if(empty($ip)) return res(400, 'Dữ liệu đầu vào sai');

    $log = (new _PDO())->select(self::$PDO_GetIPClient, array('ip' => $ip));

    if(empty($log)) return res(400, 'IP không tồn tại');
    return $log;
  }
}