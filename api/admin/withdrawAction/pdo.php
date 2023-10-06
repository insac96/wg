<?php
class WithdrawPDO {
  static $PDO_GetAllWithdraw = "SELECT
    withdraw.*, auth.bank_name, auth.bank_person, auth.bank_stk
    FROM ny_withdraw withdraw
    LEFT JOIN ny_auth auth ON withdraw.account = auth.account
  ";
  
  static $PDO_GetWithdraw = "SELECT * FROM ny_withdraw WHERE code=:code";
}