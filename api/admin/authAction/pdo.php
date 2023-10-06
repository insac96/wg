<?php
class AuthPDO {
  static $PDO_GetAuthCheckByToken = "SELECT * FROM ny_auth WHERE token=:token";
  static $PDO_GetAuthCheckByPhone = "SELECT * FROM ny_auth WHERE phone=:phone";
}