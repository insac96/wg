<?php
require 'pdo.php';

class NotifyUtils extends NotifyPDO {
  /* Create Notify */
  public function create ($account, $content, $type) {
    (new _PDO())->create('ny_notify', array(
      'account' => (string)$account,
      'type' => (string)$type,
      'content' => (string)$content,
      'create_time' => time()
    ));
  }
}