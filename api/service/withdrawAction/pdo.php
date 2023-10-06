<?php
class WithdrawPDO {
  static $PDO_GetWithdrawByToken = "SELECT id FROM ny_withdraw WHERE token=:token";
}