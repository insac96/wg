<?php
require 'utils.php';

class Ads extends AdsUtils {
  /* Get All Ads */
  public function getAllAds () {
    return getTableList('ny_ads', self::$PDO_GetAllAds);
  }

  /* Create Ads */
  public function createAds () {
    if(
      empty($_POST['name']) 
      || empty($_POST['type']) 
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Create
    (new _PDO())->create('ny_ads', array(
      'name' => (string)$_POST['name'],
      'type' => (string)$_POST['type'],
      'display' => (int)$_POST['display'],
      'create_time' => time()
    ));

    // Log
    logAdmin('Tạo chiến dịch quảng cáo ['.$_POST['name'].']');
  }
  
  /* Update Ads */
  public function updateAds () {
    if(
      !is_numeric($_POST['id']) 
      || empty($_POST['name'])
      || empty($_POST['type']) 
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Ads
    $ads = $this->getAds($_POST['id']);

    // Update
    (new _PDO())->update('ny_ads',
      array(
        'name' => (string)$_POST['name'],
        'type' => (string)$_POST['type'],
        'display' => (int)$_POST['display']
      ),
      array(
        'id' => $ads['id']
      )
    );

    // Log
    logAdmin('Cập nhật chiến dịch quảng cáo ['.$ads['name'].']');
  }

  /* Get Ads Revenue */
  public function getAdsRevenue () {
    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];
    $ads_id = $_POST['ads_id'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') AS date
      FROM ny_pay pay
      LEFT JOIN ny_auth auth ON auth.account = pay.account
      WHERE DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') <= '$end'
      AND auth.reg_from = '$ads_id'
      GROUP BY date
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(DISTINCT pay.account) AS user_pay,
      SUM(CASE WHEN pay.status = 1 THEN pay.money ELSE 0 END) AS pay_all,
      SUM(CASE WHEN pay.status = 1 AND gate.type = 1 THEN pay.money ELSE 0 END) AS pay_banking,
      SUM(CASE WHEN pay.status = 1 AND gate.type = 2 THEN pay.money ELSE 0 END) AS pay_card,
      SUM(CASE WHEN pay.status = 1 AND gate.type = 3 THEN pay.money ELSE 0 END) AS pay_momo,
      DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') AS date
      FROM ny_pay pay
      LEFT JOIN ny_gate gate ON pay.gate_id = gate.id
      LEFT JOIN ny_auth auth ON auth.account = pay.account
      WHERE
      DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') <= '$end'
      AND auth.reg_from = '$ads_id'
      GROUP BY date
    ";
    
    return getTableList(null, $sql, $count);
  }

  /* Get Ads Sign Up */
  public function getAdsSignUp () {
    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];
    $ads_id = $_POST['ads_id'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') AS table_date
      FROM ny_user user
      LEFT JOIN ny_auth auth ON auth.account = user.account
      WHERE DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') <= '$end'
      AND auth.reg_from = '$ads_id'
      GROUP BY table_date
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(user.id) as sign_up_all,
      COUNT(CASE WHEN auth.referraler IS NULL THEN user.id ELSE NULL END) AS sign_up_no_referral,
      COUNT(CASE WHEN auth.referraler IS NOT NULL THEN user.id ELSE NULL END) AS sign_up_referral,
      DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') AS table_date
      FROM ny_user user
      LEFT JOIN ny_auth auth ON auth.account = user.account
      WHERE DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') <= '$end'
      AND auth.reg_from = '$ads_id'
      GROUP BY table_date
    ";

    return getTableList(null, $sql, $count);
  }
}