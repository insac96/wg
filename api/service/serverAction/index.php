<?php
require 'utils.php';
require_once API_DIR.'/game/index.php';

class Server extends ServerUtils {
  public function getServerRank () {
    if(empty($_POST['server_id']) || empty($_POST['type'])) return res('Dữ liệu đầu vào sai');

    // Set Data
    $server_id = $_POST['server_id'];
    $type = $_POST['type'];

    // Get Gifts
    $gifts = $this->getAllServerRankGift($server_id, $type);
    
    // Set Limit
    if(count($gifts) == 0){
      $limit = 10;
    }
    else {
      $end = $gifts[count($gifts) - 1];
      $limit = $end['max'];
    }

    // Get Rank
    if($type == 'power')
      $ranks = (new Game())->getRankPower($server_id, $limit);
    else if($type == 'level')
      $ranks = (new Game())->getRankLevel($server_id, $limit);
    else
      $ranks = array('list' => []);
      
    return array(
      'ranks' => $ranks['list'],
      'gifts' => $gifts
    );
  }
}