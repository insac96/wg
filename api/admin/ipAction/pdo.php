<?php
class IPClientPDO {
  static $PDO_GetAllIPClient = "SELECT 
    log.*,
    (SELECT COUNT(DISTINCT login.account) FROM ny_log_login login WHERE login.ip = log.ip) AS account_total
    FROM ny_log_ip log
  ";
  static $PDO_GetIPClient = "SELECT * FROM ny_log_ip WHERE ip=:ip";
}