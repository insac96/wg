<?php
require 'utils.php';

class Statistical extends StatisticalUtils {
  /* Get Statistical Revenue */
  public function getStatisticalRevenue () {
    $revenueAll = (new _PDO())->select(self::$PDO_GetRevenueAll, []);
    $revenueDay = (new _PDO())->select(self::$PDO_GetRevenueDay, []);
    $revenuePrevDay = (new _PDO())->select(self::$PDO_GetRevenuePrevDay, []);
    $revenueMonth = (new _PDO())->select(self::$PDO_GetRevenueMonth, []);
    $revenuePrevMonth = (new _PDO())->select(self::$PDO_GetRevenuePrevMonth, []);

    $revenue =  array(
      'prev_day' => $this->returnRevenuePay($revenuePrevDay),
      'day' => $this->returnRevenuePay($revenueDay),
      'prev_month' => $this->returnRevenuePay($revenuePrevMonth),
      'month' => $this->returnRevenuePay($revenueMonth),
      'all' => $this->returnRevenuePay($revenueAll)
    );

    return $revenue;
  }

  /* Get Statistical Table Revenue */
  public function getStatisticalTableRevenue () {
    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS date
      FROM ny_pay 
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY date
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(DISTINCT pay.account) AS user_pay,
      COUNT(CASE WHEN 1 = 1 THEN 1 ELSE NULL END) AS pay_count,
      COUNT(CASE WHEN pay.status = 1 THEN 1 ELSE NULL END) AS pay_success,
      COUNT(CASE WHEN pay.status = 2 THEN 1 ELSE NULL END) AS pay_refuse,
      COUNT(CASE WHEN pay.status = 0 THEN 1 ELSE NULL END) AS pay_wait,
      SUM(CASE WHEN pay.status = 1 THEN pay.money ELSE 0 END) AS pay_all,
      SUM(CASE WHEN pay.status = 1 AND gate.type = 1 THEN pay.money ELSE 0 END) AS pay_banking,
      SUM(CASE WHEN pay.status = 1 AND gate.type = 2 THEN pay.money ELSE 0 END) AS pay_card,
      SUM(CASE WHEN pay.status = 1 AND gate.type = 3 THEN pay.money ELSE 0 END) AS pay_momo,
      DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') AS date
      FROM ny_pay pay
      LEFT JOIN ny_gate gate ON pay.gate_id = gate.id
      WHERE
      DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(pay.create_time), '%Y-%m-%d') <= '$end'
      GROUP BY date
    ";
    
    return getTableList(null, $sql, $count);
  }

  /* Get Statistical Sign Up */
  public function getStatisticalSignUp () {
    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_user
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(user.id) as sign_up_all,
      COUNT(CASE WHEN auth.referraler IS NULL THEN user.id ELSE NULL END) AS sign_up_no_referral,
      COUNT(CASE WHEN auth.referraler IS NOT NULL THEN user.id ELSE NULL END) AS sign_up_referral,
      DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') AS table_time
      FROM ny_user user
      LEFT JOIN ny_auth auth ON user.account = auth.account
      WHERE DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(user.create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";

    return getTableList(null, $sql, $count);
  }

  /* Get Statistical Sign In */
  public function getStatisticalSignIn () {
    $now = convertTime();
    $start = empty($_POST['start']) ? '2000-01-01' : $_POST['start'];
    $end = empty($_POST['end']) ? $now['sql'] : $_POST['end'];

    $sqlCount = "SELECT
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_login
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";
    $countQuery = (new _PDO())->select($sqlCount, [], true);
    $count = count($countQuery);

    $sql = "SELECT
      COUNT(account) as sign_in,
      DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') AS table_time
      FROM ny_log_login
      WHERE DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') >= '$start'
      AND DATE_FORMAT(FROM_UNIXTIME(create_time), '%Y-%m-%d') <= '$end'
      GROUP BY table_time
    ";

    return getTableList(null, $sql, $count);
  }
}