<?php
class GameUtils {
  /* Get All Server Admin */
  public function getAllServerAdmin () {
    if(DEV){
      $list = [];
      $list[] = array('server_id' => 'sf1', 'server_name' => 'Máy Chủ 1', 'db_name' => 'game_1');
      $list[] = array('server_id' => 'sf2', 'server_name' => 'Máy Chủ 2', 'db_name' => 'game_2');
      $list[] = array('server_id' => 'sf3', 'server_name' => 'Máy Chủ 3', 'db_name' => 'game_3');
      $list[] = array('server_id' => 'sf4', 'server_name' => 'Máy Chủ 4', 'db_name' => 'game_4');
      return $list;
    }

    $sql = "SELECT 
      server.server_id, 
      server.name AS server_name,
      config.mysql_db AS db_name
      FROM ny_server server
      LEFT JOIN ny_server_config config
      ON server.server_id = config.server_id
    ";

    $list = (new _PDO('backstage'))->select($sql, [], true);
    return $list;
  }

  /* Get Server */
  public function getServer ($server_id) {
    $sql = "SELECT 
      server.server_id, server.name AS server_name,
      config.websocket_host, config.websocket_port, config.mysql_db
      FROM ny_server server
      LEFT JOIN ny_server_config config
      ON server.server_id = config.server_id
      WHERE server.server_id=:server_id";

    $server = (new _PDO('backstage'))->select($sql, array('server_id' => $server_id));
    if(empty($server)) return res(400, 'Máy chủ không tồn tại');
    return $server;
  }

  /* Get Role By Server */
  public function getRoleByServer ($account, $server_id) {
    if(empty($server_id) || empty($account)) return res(400, 'Dữ liệu đầu vào sai');

    // Check Server
    $server = $this->getServer($server_id);

    // Get Role
    $account = 'local_'.$account;
    $dbgame = $server['mysql_db'];
    $sql = "SELECT role_id, name AS role_name FROM ny_role WHERE account=:account";
    $role = (new _PDO($dbgame))->select($sql, array('account' => $account));

    if(empty($role)) return res(400, 'Chưa có nhân vật ở máy chủ này');

    $role['server'] = $server;
    return $role;
  }

  /* Get Account By Role */
  public function getAccountByRole ($role_name, $server_id) {
    if(empty($server_id) || empty($role_name)) return res(400, 'Dữ liệu đầu vào sai');

    // Check Server
    $server = $this->getServer($server_id);

    // Get Role
    $dbgame = $server['mysql_db'];
    $sql = "SELECT role_id, name AS role_name, account FROM ny_role WHERE name=:name";
    $role = (new _PDO($dbgame))->select($sql, array('name' => $role_name));

    if(empty($role)) return res(400, 'Không tìm thấy nhân vật ở máy chủ này');
    return $role['account'];
  }

  /* Send Item */
  public function sendItems ($account, array $data) {
    if(DEV) return true;

    // Check Role
    $role = $this->getRoleByServer($account, $data['server_id']);
    $server = $role['server'];

    // Set Mail
    $title = '[Hệ Thống]';
    $content = 'Vật phẩm được gửi từ hệ thống';
    $roles = array(intval($role['role_id']));
    $items = [];

    for ($i=0; $i < count($data['items']); $i++) { 
      $item = (array)$data['items'][$i];
      $items[] = [ intval($item['id']), intval($item['amount']) ];
    }

    // Set Params
    $str = array($items, $title, $content, $roles);
    $params = ['opcode' => 0x2726942, 'str' => $str];

    // Send
    $result = sendSocket($server['websocket_host'], $server['websocket_port'], $params);
    if($result == 2) return res(400, 'Gửi vật phẩm vào trò chơi thất bại, vui lòng thử lại sau');
  }

  /* Send Recharge */
  public function sendRecharge ($account, array $data) {
    if(DEV) return true;

    // Check Role
    $role = $this->getRoleByServer($account, $data['server_id']);
    $server = $role['server'];

    // Set Mail
    $time = time();
		$orderNum = $time.mt_rand(100,999);
    $createTime = intval($time) * 1000;
    $roleSend = intval($role['role_id']);
    $id = (int)$data['recharge']['id'];
		$save_pay = (int)$data['recharge']['save_pay_ingame'];

    // Set Params
    $str[] = [ $orderNum, $roleSend, $id, $save_pay, $createTime, true ];
    $params = ['opcode' => 0x2751741, 'str' => array($str)];

    // Send
    $result = sendSocket($server['websocket_host'], $server['websocket_port'], $params);
    if($result == 2) return res(400, 'Gửi vật phẩm vào trò chơi thất bại, vui lòng thử lại sau');
  }
}