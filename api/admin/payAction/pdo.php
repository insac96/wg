<?php
class PayPDO {
  static $PDO_GetAllPay = "SELECT
    pay.*, gate.name as gate_name
    FROM ny_pay pay
    LEFT JOIN ny_gate gate ON pay.gate_id = gate.id
  ";

  static $PDO_GetPay = "SELECT * FROM ny_pay WHERE code=:code";

  static $PDO_GetPayBuyToken = "SELECT * FROM ny_pay WHERE token=:token";
}