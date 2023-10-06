<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

include_once('../../config.php');
require_once API_DIR.'/includes/utils.php';
require_once API_DIR.'/includes/pdo.php';
require_once API_DIR.'/service/configAction/index.php';
require_once API_DIR.'/service/notifyAction/index.php';
require_once API_DIR.'/service/userAction/index.php';
require_once API_DIR.'/service/payAction/index.php';
require_once API_DIR.'/service/gateAction/index.php';
require_once API_DIR.'/service/vipAction/index.php';
require_once API_DIR.'/payment/momo/index.php';

$rawInput = file_get_contents("php://input");
$data = (array)json_decode($rawInput);
$config = (new Config())->getConfigAll();

if(empty($data['signature']) || $data['signature'] != $config['api_key_momo']){
  res(403, 'Không có quyền truy cập');
}
else {
  (new MomoPayment())->callback($data);
}
