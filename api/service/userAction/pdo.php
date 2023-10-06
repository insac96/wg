<?php
class UserPDO {
  static $PDO_GetUser = "SELECT * 
    FROM ny_user user
    LEFT JOIN ny_auth auth ON user.account = auth.account
    WHERE user.account=:account
  ";

  static $PDO_GetReferraler = "SELECT
    user.account, vip.*
    FROM ny_user user
    LEFT JOIN ny_vip vip ON user.vip = vip.number
    WHERE account=:referraler
  ";

  static $PDO_GetLastLogin = "SELECT id, create_time FROM ny_log_login WHERE ip=:ip AND account=:account ORDER BY create_time DESC LIMIT 1";
}