<?php
class AuthPDO {
  static $PDO_GetAuthCheckByAccount = "SELECT * FROM ny_auth WHERE account=:account";
  static $PDO_GetAuthCheckByPhone = "SELECT * FROM ny_auth WHERE phone=:phone";
  static $PDO_GetAuthCheckByToken = "SELECT * FROM ny_auth WHERE token=:token";
  static $PDO_GetReferralerByCode = "SELECT account FROM ny_auth WHERE referral_code=:referral_code";
}