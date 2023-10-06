<?php
class PayPDO {
  static $PDO_GetPay = "SELECT * FROM ny_pay WHERE code=:code";
  static $PDO_GetPayByToken = "SELECT * FROM ny_pay WHERE token=:token";
  static $PDO_GetPayCodeByToken = "SELECT code FROM ny_pay WHERE token=:token";
}