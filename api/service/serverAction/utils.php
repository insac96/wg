<?php
require 'pdo.php';

class ServerUtils extends ServerPDO {
  /* Get All Server Rank Gift */
  public function getAllServerRankGift ($server_id, $type) {
    return (new _PDO())->select(self::$PDO_GetAllServerRankGift, array(
      'server_id' => (string)$server_id,
      'type' => (string)$type
    ), true);
  }
}