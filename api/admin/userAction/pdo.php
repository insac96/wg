<?php
class UserPDO {
  static $PDO_GetAllUser = "SELECT 
    user.*,
    auth.block, auth.phone, auth.type as type_user, auth.referraler
    FROM ny_user user
    LEFT JOIN ny_auth auth ON user.account = auth.account
  ";
  
  static $PDO_GetUser = "SELECT * 
    FROM ny_user user
    LEFT JOIN ny_auth auth ON user.account = auth.account
    WHERE user.account=:account
  ";
}