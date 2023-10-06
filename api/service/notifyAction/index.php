<?php
require 'utils.php';

class Notify extends NotifyUtils {
  public function getAllNotify ($user) {
    $account = $user['account'];

    // Update View
    (new _PDO())->update('ny_notify', array('view'=>1), array('account'=>$account));

    // Get List
    $sqlCount = "SELECT count(id) AS total FROM ny_notify WHERE account=:account";
    $sql = "SELECT * FROM ny_notify WHERE account='$account'";

    if(empty($_POST['tab']) || $_POST['tab'] == 'all'){
      $count = (new _PDO())->select($sqlCount, array(
        'account' => $account
      ));
      $count = $count['total'];
      return getTableList(null, $sql, $count);
    }

    else if($_POST['tab'] == 'referral'){
      $sqlAdd = "AND type IN ('invitee', 'referral')";
      $count = (new _PDO())->select($sqlCount." ".$sqlAdd, array(
        'account' => $account
      ));

      $count = $count['total'];
      return getTableList(null, $sql." ".$sqlAdd, $count);
    }

    else {
      $type = (string)$_POST['tab'];
      $sqlAdd = "AND type=:type";
      $count = (new _PDO())->select($sqlCount." ".$sqlAdd, array(
        'account' => (string)$account,
        'type' => $type
      ));
      $count = $count['total'];
      return getTableList(null, $sql." AND type='$type'", $count);
    }
  }
}