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

  /* Get Count Notify */
  public function getCountNewNotify ($account) {
    $sql = "SELECT count(id) AS total FROM ny_notify WHERE account=:account AND view < '1'";
    $count = (new _PDO())->select($sql, array(
      'account' => $account,
    ));

    if(empty($count)) return 0;
    if(empty($count['total'])) return 0;
    return $count['total'];
  }
}