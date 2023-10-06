<?php
require 'utils.php';
require 'socket/index.php';

class Game extends GameUtils {
  /* Get All Server */
  public function getAllServer () {
    if(DEV){
      $list = [];
      $list[] = array('server_id' => 'sf1', 'server_name' => 'Máy Chủ 1', 'db_name' => 'game_1');
      $list[] = array('server_id' => 'sf2', 'server_name' => 'Máy Chủ 2', 'db_name' => 'game_2');
      $list[] = array('server_id' => 'sf3', 'server_name' => 'Máy Chủ 3', 'db_name' => 'game_3');
      $list[] = array('server_id' => 'sf4', 'server_name' => 'Máy Chủ 4', 'db_name' => 'game_4');
      return $list;
    }

    /* Prod */
    $sql = "SELECT server_id, name AS server_name FROM ny_server";
    $list = (new _PDO('backstage'))->select($sql, [], true);
    return $list;
  }

  /* Get Role  */
  public function getRole ($user) {
    if(DEV){
      $role = array('role_id' => '1234567', 'role_name' => 'S1.Admin');
      return $role;
    }

    /* Prod */
    $role = $this->getRoleByServer($user['account'], $_POST['server_id']);
    return $role;
  }

  /* Login Game */
  public function loginGame ($user) {
    if(empty($_POST['server_id'])) return res(400, 'Chưa có thông tin máy chủ');

    $server_id = $_POST['server_id'];
    $account = $user['account'];
    $time = convertTime();
    $create_new_login = false;

    $sql = "SELECT id, create_time FROM ny_log_login_server WHERE server_id=:server_id AND account=:account ORDER BY create_time DESC LIMIT 1";
    $lastLogin = (new _PDO())->select($sql, array(
      'server_id' => (string)$server_id,
      'account' => (string)$account 
    ));

    if(empty($lastLogin)){
      $create_new_login = true;
    }
    else {
      $lastTimeLogin = convertTime($lastLogin['create_time']);
      if($lastTimeLogin['date'] != $time['date'])
        $create_new_login = true;
    }

    if($create_new_login){
      (new _PDO())->create('ny_log_login_server', array(
        'account' => (string)$account,
        'server_id' => (string)$server_id,
        'create_time' => (int)$time['timestamp']
      ));
    }
  }

  /* Get Rank Power */
  public function getRankPower ($server_id, $limit) {
    if(empty($server_id) || !is_numeric($limit)) return res(400, 'Dữ liệu đầu vào sai');

    // Check Server
    $server = $this->getServer($server_id);
    $dbgame = $server['mysql_db'];
    
    // Get
    $sql = "SELECT
      account, power,
      name AS role_name,
      (SELECT @n := @n + 1 n FROM (SELECT @n := 0) m) AS rank
      FROM ny_role
      ORDER BY power DESC
      LIMIT $limit
    ";
    
    $list = (new _PDO($dbgame))->select($sql, [], true);
    
    return array(
      'list' => $list,
      'total_page' => 1
    );
  }
  
  /* Get Rank Level */
  public function getRankLevel ($server_id, $limit) {
    if(empty($server_id) || !is_numeric($limit)) return res(400, 'Dữ liệu đầu vào sai');

    // Check Server
    $server = $this->getServer($server_id);
    $dbgame = $server['mysql_db'];
    
    // Get
    $sql = "SELECT
      account,
      name AS role_name,
      role_level AS level,
      (SELECT @n := @n + 1 n FROM (SELECT @n := 0) m) AS rank
      FROM ny_role
      ORDER BY role_level DESC
      LIMIT $limit
    ";
    
    $list = (new _PDO($dbgame))->select($sql, [], true);
    
    return array(
      'list' => $list,
      'total_page' => 1
    );
  }
}
