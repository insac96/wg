<?php
/* Make Expires Time */
function makeExpires ($date, $time) {
  if(empty($date)){
    $expires_time = 0;
  }
  else {
    $expires_time = strtotime($date.' '.($time ? $time : "00:00"));
  }

  if($expires_time < 0){
    $expires_time = 0;
  }

  return $expires_time;
}

/* Log Admin */
function logAdmin ($action) {
  $authCheck = (new Auth())->getAuthCheckByToken();
  if(empty($authCheck)) return res(400, 'Hành động được thực hiện nhưng lưu ghi chép thất bại');

  (new _PDO())->create('ny_log_admin', array(
    'type' => (string)$_POST['action-run'],
    'account' => $authCheck['account'],
    'action' => (string)$action,
    'create_time' => time()
  ));
}

