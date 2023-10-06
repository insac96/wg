<?php
require 'pdo.php';

class StatisticalUtils extends StatisticalPDO {
  public function returnRevenuePay ($data) {
    if(empty($data)) return 0;
    if(empty($data['pay'])) return 0;
    return (int)$data['pay'];
  }
}