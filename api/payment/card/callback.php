<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET');

include_once('../../config.php');
require_once API_DIR.'/includes/utils.php';
require_once API_DIR.'/includes/pdo.php';
require_once API_DIR.'/service/configAction/index.php';
require_once API_DIR.'/service/notifyAction/index.php';
require_once API_DIR.'/service/userAction/index.php';
require_once API_DIR.'/service/payAction/index.php';
require_once API_DIR.'/service/gateAction/index.php';
require_once API_DIR.'/service/vipAction/index.php';
require_once API_DIR.'/payment/card/index.php';

if(isset($_GET['Code'], $_GET['Mess'], $_GET['Reason'], $_GET['CardValue'], $_GET['TrxID'])) {
  (new CardPayment())->callback($_GET);
}