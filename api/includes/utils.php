<?php
/* Response API JSON */
function res ($code = 200, $msg = null, $data = null) {
  $return = array(
    'code' => $code,
    'msg' => $msg,
    'data' => $data
  );

  die(json_encode($return));
  exit();
}

/* Error Handler */
function errorHandler ($errno, $errstr) {
  res(500, '['.$errno.'] '.$errstr);
}

/* Get Client IP */
function getClientIP ($adv = true){
  $ip = null;

  if ($adv) {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
      $pos = array_search('unknown', $arr);
      if (false !== $pos) {
        unset($arr[$pos]);
      }
      $ip = trim($arr[0]);
    } 
    else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } 
    else if (isset($_SERVER['REMOTE_ADDR'])) {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
  }
  else if (isset($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
  }

  $long = sprintf('%u', ip2long($ip));
  if(empty($long)) return res(403, 'Vui lòng tuy cập bằng địa chỉ IP hợp lệ');
  return $ip;
}

/* Check Block IP */
function checkBlockIP () {
  $IP = getClientIP();
  $log = (new _PDO())->select("SELECT block, connect FROM ny_log_ip WHERE ip=:ip", array(
    'ip' => (string)$IP
  ));

  if(empty($log)){
    (new _PDO())->create('ny_log_ip', array(
      'ip' => (string)$IP,
      'update_time' => time()
    ));
    return;
  }
  else {
    (new _PDO())->update('ny_log_ip', array(
      'update_time' => time(),
      'connect' => array('+', 1)
    ), array(
      'ip' => (string)$IP
    ));

    if($log['block'] != 1) return;
    if($log['block'] == 1) return res('405', 'Bạn bị chặn quyền truy cập');
  }
}

/* Convert Time */
function convertTime ($time = null) {
  $time = isset($time) ? $time : time();

  $data = array(
    'date' => date('d', $time),
    'month' => date('m', $time),
    'year' => date('Y', $time),
    'hour' => date('H', $time),
    'minute' => date('i', $time),
    'second' => date('s', $time),
    'full_date' => date('dmY', $time),
    'full_time' => date('H:i:s', $time),
    'full' => date('d/m/Y - H:i:s', $time),
    'sql' => date('Y-m-d', $time),
    'timestamp' => $time
  );

  return $data;
}

/* Get Expires */
function isExpires ($time) {
  if((int)$time == 0) return false;

  $now = time();
  if((int)$now < (int)$time) return false;
  return true;
}

/* Get Count DB */
function getCountDB ($name) {
  $sql = "SELECT count(id) AS total FROM ".$name;
  $count = (new _PDO())->select($sql, null);
  return $count['total'];
}

/* Get Start Page */
function getPage ($count) {
  $page = !empty($_POST['page']) ? (int)$_POST['page'] : 1;
  $limit = !empty($_POST['limit']) ? (int)$_POST['limit'] : 10;
  $total = ceil((int)$count / $limit);

  if($page > $total){
    $page = $total;
  }
  else if ($page < 1){
    $page = 1;
  }

  $start = ($page - 1) * $limit;
  return array(
    'start' => (int)$start,
    'limit' => (int)$limit,
    'total' => (int)$total
  );
}

/* Get Table Search */
function getTableList ($table, $sql, $count = null) {
  if(!isset($count)){
    $count = getCountDB($table);
  }

  $page = getPage($count);
  $start = $page['start'];
  $limit = $page['limit'];
  $sort_by = empty($_POST['sort']) ? 'id' : $_POST['sort']['by'];
  $sort_type = empty($_POST['sort']) ? 'DESC' : $_POST['sort']['type'];

  $sql = $sql." ORDER BY $sort_by $sort_type LIMIT $start, $limit";
  $list = (new _PDO())->select($sql, [], true);
  
  return array(
    'list' => $list,
    'total_page' => $page['total']
  );
}

/* Get Table List */
function getTableSearch ($sqlCount, $sqlSearch) {
  if(empty($_POST['search'])) return res(400, 'Vui lòng nhập dữ liệu tìm kiếm');
  $query = $_POST['search'];
  $query = "%$query%";

  $countQuery = (new _PDO())->select($sqlCount, array('query' => $query));
  if(empty($countQuery) || $countQuery['total'] < 1)
    res(400, 'Không tìm thấy ghi chép nào hợp lệ');

  $count = (int)$countQuery['total'];
  $page = getPage($count);
  $start = $page['start'];
  $limit = $page['limit'];
  $sort_by = empty($_POST['sort']) ? 'id' : $_POST['sort']['by'];
  $sort_type = empty($_POST['sort']) ? 'DESC' : $_POST['sort']['type'];

  $sqlSearch = $sqlSearch." ORDER BY $sort_by $sort_type LIMIT $start, $limit";
  $list = (new _PDO())->select($sqlSearch, array(
    'query' => $query
  ), true);

  return array(
    'list' => $list,
    'total_page' => $page['total']
  );
}

