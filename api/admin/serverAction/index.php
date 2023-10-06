<?php
require 'utils.php';
require_once API_DIR.'/game/index.php';

class Server extends ServerUtils {
  /* Get All Server */
  public function getAllServer () {
    return getTableList('ny_server', self::$PDO_GetAllServer);
  }

  /* Sync Server */
  public function syncServer () {
    $list = (new Game())->getAllServerAdmin();

    foreach ($list as $server) {
      $had = $this->getServer($server['server_id'], true);
      if(!$had){
        (new _PDO())->create('ny_server', array(
          'server_id' => (string)$server['server_id'],
          'server_name' => (string)$server['server_name'],
          'db_name' => (string)$server['db_name'],
          'update_time' => time()
        ));
      }
      else {
        (new _PDO())->update('ny_server', array(
          'server_name' => (string)$server['server_name'],
          'db_name' => (string)$server['db_name'],
          'update_time' => time()
        ), array(
          'server_id' => (string)$server['server_id']
        ));
      }
    }
  }

  /* Stop Server */
  public function deleteServer () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào không đủ');

    $server = $this->getServer($_POST['server_id']);
    (new _PDO())->delete(self::$PDO_DeleteServer, array('server_id' => $server['server_id']));
    logAdmin('Xóa máy chủ ['.$server['server_name'].']');
  }

  /* Get Log Server Login */
  public function getLogServerLogin () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = $_POST['server_id'];

    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_login_server
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      AND server_id = '$server_id'
      GROUP BY table_time
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(account) as sign_in,
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_login_server
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      AND server_id = '$server_id'
      GROUP BY table_time
    ";

    return getTableList(null, $sql, $count);
  }

  /* Get Log Server Spend */
  public function getLogServerSpend () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = $_POST['server_id'];

    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_shop 
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(DISTINCT account) AS user_spend,
      COUNT(CASE WHEN 1 = 1 THEN 1 ELSE NULL END) AS spend_count,
      COUNT(CASE WHEN shop_type = 'recharge' THEN 1 ELSE NULL END) AS spend_count_recharge,
      COUNT(CASE WHEN shop_type = 'item' THEN 1 ELSE NULL END) AS spend_count_item,
      SUM(CASE WHEN 1 = 1 THEN price ELSE 0 END) AS spend_all,
      SUM(CASE WHEN shop_type = 'recharge' THEN price ELSE 0 END) AS spend_recharge,
      SUM(CASE WHEN shop_type = 'item' THEN price ELSE 0 END) AS spend_item,
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_shop
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";

    return getTableList(null, $sql, $count);
  }

  /* Get Server Rank Spend */
  public function getServerRankSpend () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = $_POST['server_id'];

    $now = convertTime();
    $start = empty($_POST['start']) ? $now['sql'] : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      account
      FROM ny_log_shop 
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY account
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      SUM(CASE WHEN 1 = 1 THEN price ELSE 0 END) AS spend_all,
      SUM(CASE WHEN shop_type = 'recharge' THEN price ELSE 0 END) AS spend_recharge,
      SUM(CASE WHEN shop_type = 'item' THEN price ELSE 0 END) AS spend_item,
      account
      FROM ny_log_shop
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY account
    ";

    return getTableList(null, $sql, $count);
  }

  /* Get Server Rank Power */
  public function getServerRankPower () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = (string)$_POST['server_id'];
    $limit = (int)$_POST['limit'];
    $list = (new Game())->getRankPower($server_id, $limit);
    return $list;
  }

  /* Get Server Rank Level */
  public function getServerRankLevel () {
    if(empty($_POST['server_id'])) return res(400, 'Dữ liệu đầu vào sai');
    $server_id = (string)$_POST['server_id'];
    $limit = (int)$_POST['limit'];
    $list = (new Game())->getRankLevel($server_id, $limit);
    return $list;
  }

  /* Get All Server Rank Gift */
  public function getAllServerRankGift () {
    if(empty($_POST['server_id']) || empty($_POST['type'])) return res('Dữ liệu đầu vào sai');

    $server_id = $_POST['server_id'];
    $type = $_POST['type'];
    $sqlCount = "SELECT id FROM ny_server_rank_gift WHERE server_id=:server_id AND type=:type";
    $countQuery = (new _PDO())->select($sqlCount, array(
      'server_id' => $server_id,
      'type' => $type,
    ), true);
    $count = count($countQuery);
    $sql = "SELECT * FROM ny_server_rank_gift WHERE server_id = '$server_id' AND type = '$type'";
    return getTableList(null, $sql, $count);
  }

  /* Create Server Rank Gift */
  public function createServerRankGift () {
    if(
      empty($_POST['server_id']) 
      || empty($_POST['type'])
      || !is_numeric($_POST['min'])
      || !is_numeric($_POST['max'])
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Check Min, Max
    if((int)$_POST['min'] == 0 || (int)$_POST['max'] == 0)
      res(400, 'Thứ hạng không thể bằng 0');
    
    // Check Gift
    $gifts = (array)json_decode((string)$_POST['gifts']);
    if(!is_array($gifts))
      res(400, 'Phần thưởng đưa vào không hợp lệ');

    // Create
    (new _PDO())->create('ny_server_rank_gift', array(
      'server_id' => (string)$_POST['server_id'],
      'type' => (string)$_POST['type'],
      'min' => (int)$_POST['min'],
      'max' => (int)$_POST['max'],
      'gifts' => (string)$_POST['gifts']
    ));

    // Log
    logAdmin('Tạo phần thưởng xếp hạng trên máy chủ ['.$_POST['server_id'].']');
  }

  /* Update Server Rank Gift */
  public function updateServerRankGift () {
    if(
      !is_numeric($_POST['id'])
      || empty($_POST['server_id']) 
      || !is_numeric($_POST['min'])
      || !is_numeric($_POST['max'])
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Get Rank Gift
    $rank_gift = $this->getServerRankGift($_POST['id']);

    // Check Min, Max
    if((int)$_POST['min'] == 0 || (int)$_POST['max'] == 0)
      res(400, 'Thứ hạng không thể bằng 0');
    
    // Check Gift
    $gifts = (array)json_decode((string)$_POST['gifts']);
    if(!is_array($gifts))
      res(400, 'Phần thưởng đưa vào không hợp lệ');

    // Create
    (new _PDO())->update('ny_server_rank_gift', array(
      'min' => (int)$_POST['min'],
      'max' => (int)$_POST['max'],
      'gifts' => (string)$_POST['gifts']
    ), array(
      'id' => (int)$rank_gift['id']
    ));

    // Log
    logAdmin('Cập nhật phần thưởng hạng trên máy chủ ['.$rank_gift['server_id'].']');
  }

  /* Delete Server Rank Gift */
  public function deleteServerRankGift () {
    $rank_gift = $this->getServerRankGift($_POST['rank_gift_id']);

    (new _PDO())->delete(self::$PDO_DeleteServerRankGift, array('id' => $rank_gift['id']));
    logAdmin('Xóa phần thưởng xếp hạng tại máy chủ ['.$rank_gift['server_id'].']');
  }

  /* Send Rank Gift Spend */
  public function sendRankGiftSpend () {
    if(
      !is_numeric($_POST['limit'])
      || empty($_POST['start'])
      || empty($_POST['end'])
      || empty($_POST['server_id'])
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Set Data
    $server_id = (string)$_POST['server_id'];
    $start = (string)$_POST['start'];
    $end = (string)$_POST['end'];
    $limit = (int)$_POST['limit'];

    // Get List Account
    $sql = "SELECT
      SUM(CASE WHEN 1 = 1 THEN price ELSE 0 END) AS spend_all,
      (SELECT @n := @n + 1 n FROM (SELECT @n := 0) m) AS rank,
      account
      FROM ny_log_shop
      WHERE shop_type != 'currency'
      AND server_id = '$server_id'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY account
      ORDER BY spend_all DESC
    ";
    $listAccount = (new _PDO())->select($sql, [], true);
    $this->sendRankGift($listAccount, 'spend');

    // Log
    logAdmin('Gửi phần thưởng xếp hạng tiêu phí trên máy chủ ['.$server_id.']');
  }

  /* Send Rank Gift Power */
  public function sendRankGiftPower () {
    if(
      !is_numeric($_POST['limit'])
      || empty($_POST['server_id'])
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Set Data
    $server_id = (string)$_POST['server_id'];
    $limit = (int)$_POST['limit'];

    // Get List Account
    $rank = (new Game())->getRankPower($server_id, $limit);
    $listAccount = $rank['list'];
    $this->sendRankGift($listAccount, 'power');

    // Log
    logAdmin('Gửi phần thưởng xếp hạng lực chiến trên máy chủ ['.$server_id.']');
  }

  /* Send Rank Gift Power */
  public function sendRankGiftLevel () {
    if(
      !is_numeric($_POST['limit'])
      || empty($_POST['server_id'])
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Set Data
    $server_id = (string)$_POST['server_id'];
    $limit = (int)$_POST['limit'];

    // Get List Account
    $rank = (new Game())->getRankLevel($server_id, $limit);
    $listAccount = $rank['list'];
    $this->sendRankGift($listAccount, 'level');

    // Log
    logAdmin('Gửi phần thưởng xếp hạng cấp độ trên máy chủ ['.$server_id.']');
  }
}