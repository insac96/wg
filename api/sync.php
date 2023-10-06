<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: POST');
define('API', true);
define('IN_WEB', true);
include_once('./config.php');
require_once API_DIR.'/includes/utils.php';
require_once API_DIR.'/includes/pdo.php';

// $users = (new _PDO('tth5'))->select('SELECT uid, username, password, ggcoin, createdate FROM game_account', null, true);

// foreach ($users as $user) {
//   if($user['account'] != 'admin'){
//     $uid = $user['uid'];
//     $account = trim($user['username']);
//     $password = md5(trim($user['password']));
//     $coin = (int)$user['ggcoin'];
//     $date = new DateTime($user['createdate']);
//     $create_time = $date->getTimestamp();
    
//     // Pay All
//     $pay_all = (new _PDO('tth5'))->select("SELECT sum(amount) AS money FROM payment WHERE status = 1 and user_id = :user_id", array(
//         'user_id' => $uid
//     ));
//     $pay_all = !empty($pay_all['money']) ? (int)$pay_all['money'] : 0;
    
//     // Account
//     (new _PDO())->create('ny_auth', array(
//       'account' => $account,
//       'password' => $password,
//       'referral_code' => 'tth5-'.$account
//     ));

//     (new _PDO())->create('ny_user', array(
//       'account' => $account,
//       'coin' => $coin,
//       'pay_all' => $pay_all,
//       'create_time' => $create_time
//     ));
    
//     // Payment
//     $pays = (new _PDO('tth5'))->select('SELECT user_id, status, gateway, created, amount FROM payment WHERE user_id = :user_id', array(
//         'user_id' => $uid
//     ), true);
    
//     foreach ($pays as $pay) {
//         if($pay['gateway'] != 5){
//             if($pay['gateway'] == 1){
//                 $gate_id = 3;
//             }
//             else if($pay['gateway'] == 2){
//                 $gate_id = 2;
//             }
//             else if($pay['gateway'] == 3){
//                 $gate_id = 1;
//             }
//             else {
//                 $gate_id = 1;
//             }
            
//             $money = (int)$pay['amount'];
//             $status = $pay['status'];
//             $date = new DateTime($pay['created']);
//             $create_time = $date->getTimestamp();
//             $verify_time = $create_time;
//             $verifier = 'system';
//             $code = 'P'.$create_time;
//             $token = md5($code);
            
//             (new _PDO())->create('ny_pay', array(
//                 'account' => $account,
//                 'money' => $money,
//                 'gate_id' => $gate_id,
//                 'code' => $code,
//                 'token' => $token,
//                 'status' => $status,
//                 'verifier' => $verifier,
//                 'verify_time' => $verify_time,
//                 'create_time' => $create_time
//              ));
    
                
//         }
//     }
//   }
// }

// $recharges = file_get_contents("recharge.json");
// echo $recharges;
// $recharges = json_decode($recharges);

// foreach ($recharges as $recharge){
//     $id = $recharge[0];
//     $name = $recharge[1];
//     $price = $recharge[2];
    
//     (new _PDO())->create('ny_shop_recharge', array(
//         'id' => $id,
//         'name' => $name,
//         'price' => $price,
//     ));
// }