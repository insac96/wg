<?php
class CTV {
  /* Get All CTV */
  public function getAllCTV () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_auth 
      WHERE type = 1 OR type = 2
      AND account != 'admin'
    ";
    $countQuery = (new _PDO())->select($sqlCount, []);
    $count = $countQuery['total'];

    $sql = "SELECT
      auth.account, auth.type as type_user, user.referral_count,
      sumpay.pay_all, sumpay.pay_banking, sumpay.pay_card, sumpay.pay_momo
      FROM ny_auth auth
      LEFT JOIN ny_user user ON user.account = auth.account
      LEFT JOIN (
        SELECT 
        SUM(CASE WHEN 1 = 1 THEN pay.money ELSE 0 END) as pay_all,
        SUM(CASE WHEN pay.gate_id = 1 THEN pay.money ELSE 0 END) as pay_banking, 
        SUM(CASE WHEN pay.gate_id = 2 THEN pay.money ELSE 0 END) as pay_card, 
        SUM(CASE WHEN pay.gate_id = 3 THEN pay.money ELSE 0 END) as pay_momo,
        log.account
        FROM ny_log_referral log
        LEFT JOIN ny_pay pay ON pay.account = log.invitee
        WHERE pay.status = 1
        GROUP BY log.account
      ) AS sumpay ON sumpay.account = auth.account
      WHERE auth.type = 1 OR auth.type = 2
      AND auth.account != 'admin'
    ";
    
    return getTableList(null, $sql, $count);
  }

  /* Search CTV */
  public function searchCTV () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_auth 
      WHERE type = 1 OR type = 2
      AND account != 'admin'
      AND account LIKE :query
    ";

    $sqlSearch = "SELECT
      auth.account, auth.type as type_user, user.referral_count,
      sumpay.pay_all, sumpay.pay_banking, sumpay.pay_card, sumpay.pay_momo
      FROM ny_auth auth
      LEFT JOIN ny_user user ON user.account = auth.account
      LEFT JOIN (
        SELECT 
        SUM(CASE WHEN 1 = 1 THEN pay.money ELSE 0 END) as pay_all,
        SUM(CASE WHEN pay.gate_id = 1 THEN pay.money ELSE 0 END) as pay_banking, 
        SUM(CASE WHEN pay.gate_id = 2 THEN pay.money ELSE 0 END) as pay_card, 
        SUM(CASE WHEN pay.gate_id = 3 THEN pay.money ELSE 0 END) as pay_momo,
        log.account
        FROM ny_log_referral log
        LEFT JOIN ny_pay pay ON pay.account = log.invitee
        WHERE pay.status = 1
        GROUP BY log.account
      ) AS sumpay ON sumpay.account = auth.account
      WHERE auth.type = 1 OR auth.type = 2
      AND auth.account != 'admin'
      AND auth.account LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Get CTV Referral */
  public function getLogCTVReferral () {
    if(empty($_POST['account'])) return res(400, 'Vui lòng chọn tài khoản trước');

    $account = $_POST['account'];
    $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_log_referral WHERE account=:account", array(
      'account' => $account
    ));
    $count = $count['total'];

    return getTableList(null, "SELECT
      log.id, log.invitee, log.create_time,
      (SELECT SUM(money) FROM ny_pay WHERE status = 1 AND account = log.invitee) as pay_all
      FROM ny_log_referral log
      WHERE log.account='$account'
    ", $count);
  }
}