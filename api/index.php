<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST');
define('API', true);
define('IN_WEB', true);

/* Require Includes */
include_once('./config.php');
require_once API_DIR.'/includes/utils.php';
require_once API_DIR.'/includes/pdo.php';

/* Set Error Handler */
set_error_handler('errorHandler');

/* Check MAINTENANCE */
if(MAINTENANCE) return res(400, 'Hệ thống đang bảo trì, vui lòng quay lại sau');

/* Check IP Block */
checkBlockIP();

/* Set POST */
$request_body = file_get_contents('php://input');
$dataPost = json_decode($request_body, true);
if(!empty($dataPost))
  $_POST = $dataPost;

/* Require Controller */
if(empty($_POST['controller'])){
  require_once API_DIR.'/service/controller.php';
}
else {
  require_once API_DIR.'/'.$_POST['controller'].'/controller.php';
}

/* Check Controller */
if(!class_exists('Controller')) return res(403, 'Yêu cầu không hợp lệ');

/* Check Action */
if(empty($_POST['action'])) return res(403, 'Yêu cầu không hợp lệ');

/* Check POST */
$action = $_POST['action'];
$controller = new Controller();
$token = !empty($_POST['token']) ? $_POST['token'] : null;
$data = !empty($_POST['data']) ? $_POST['data'] : array();
if(!is_array($data)) return res(403, 'Dữ liệu đầu vào sai');

/* Set New POST */
$_POST = array_merge($data, array(
  'token-auth' => $token,
  'action-run' => $action
));

/* Check Action */
if(!method_exists($controller, $action)) return res(403, 'Hành động không hỗ trợ');

/* Run */
$controller->$action();
