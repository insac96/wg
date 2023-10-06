<?php
require 'utils.php';

class Pay extends PayUtils {
  /* Get All Pay Of User */
  public function getAllPay ($user) {
    $account = $user['account'];
    $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_pay WHERE account=:account", array(
      'account' => $account
    ));
    $count = $count['total'];

    return getTableList(null, "SELECT 
      pay.status, pay.money, pay.code, pay.create_time, gate.name as gate_name
      FROM ny_pay pay
      LEFT JOIN ny_gate gate ON pay.gate_id = gate.id
      WHERE pay.account='$account'
    ", $count);
  }

  /* Create Pay */
  public function createPay ($user) {  
    // Check Data
    if(!is_numeric($_POST['money']) || !is_numeric($_POST['gate_id']))
      res(400, 'Dữ liệu đầu vào sai');
    if((int)$_POST['money'] < 10000)
      res(400, 'Số tiền phải lớn hơn hoặc bằng 10.000 VNĐ');
    if((int)$_POST['money'] > 10000000)
      res(400, 'Số tiền phải nhỏ hơn hoặc bằng 10.000.000 VNĐ');
    if((int)$_POST['money'] % 10000 != 0)
      res(400, 'Số tiền phải là bội số của 10.000');

    // Get Gate
    $gate = (new Gate())->getGate($_POST['gate_id']);
    $gate_type = (int)$gate['type'];

    // Make Code
    $token = $this->makeToken();

    // Check Card
    if($gate_type == 2){
      $data = $_POST;
      $data['token'] = $token;
      (new CardPayment())->send($data);
    }

    // Create Pay
    (new _PDO())->create('ny_pay', array(
      'account' => (string)$user['account'],
      'money' => (int)$_POST['money'],
      'gate_id' => (int)$gate['id'],
      'token' => (string)$token,
      'code' => '',
      'create_time' => time()
    ));

    // Make Code and QR
    $pay = $this->getPayByToken($token);
    $pay_id = $pay['id'];
    $code = $this->makeCode($pay_id);

    if($gate_type == 3){
      $qr = $this->getQRMomo($code, $gate);
    }
    else if($gate_type == 1){
      $qr = $this->getQRBanking($code, $gate);
    }
    else {
      $qr = null;
    }

    // Update Code And QR
    (new _PDO())->update('ny_pay',
      array(
        'code' => (string)$code,
        'qr' => (string)$qr
      ), 
      array(
        'id' => $pay_id
      )
    );

    // Return
    $pay['code'] = $code;
    $pay['qr'] = $qr;

    // Check DEV
    if(DEV) return $this->verifyPayAuto((int)$_POST['money'], $code, 1);
    return $pay;
  }
}