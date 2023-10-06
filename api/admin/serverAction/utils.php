<?php
require 'pdo.php';

class ServerUtils extends ServerPDO {
  /* Get Server By ID */
  public function getServer ($server_id, $boolean = false) {
    if(empty($server_id)) return res(400, 'Không tìm thấy ID máy chủ');

    $server = (new _PDO())->select(self::$PDO_GetServer, array('server_id' => $server_id));

    if($boolean){
      if(empty($server)) return false;
      return true;
    }
    else {
      if(empty($server)) return res(400, 'Máy chủ không tồn tại');
      return $server;
    }
  }

  /* Get Server Rank Gift By ID */
  public function getServerRankGift ($id) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID phần thưởng');

    $rank_gift = (new _PDO())->select(self::$PDO_GetServerRankGift, array('id' => $id));

    if(empty($rank_gift)) return res(400, 'Phần thưởng xếp hạng không tồn tại');
    return $rank_gift;
  }

  /* Send Rank Gift */
  public function sendRankGift ($listAccount, $type) {
    $server_id = (string)$_POST['server_id'];
    $countAccount = count($listAccount);

    // Check List Account
    if($countAccount == 0)
      res(400, 'Chưa có tài khoản nào để gửi');

    // Get Gift Max
    $sql = "SELECT 
      max 
      FROM ny_server_rank_gift 
      WHERE server_id = '$server_id'
      AND type = '$type'
      ORDER BY max DESC LIMIT 1
    ";
    $query = (new _PDO())->select($sql, []);
    if(empty($query))
      res(400, 'Vui lòng thêm phần thưởng xếp hạng trước');
    
    // Check Gift Max 
    $maxRank = $query['max'];
    if($countAccount > $maxRank)
      res(400, 'Phần thưởng không đủ để gửi, vui lòng cập nhật thêm phần thưởng');

    // Check Rank Gift By Rank
    $list = [];
    $sql = "SELECT 
      gifts 
      FROM ny_server_rank_gift 
      WHERE server_id = '$server_id' 
      AND type = '$type'
      AND min <= :rank 
      AND max >= :rank
    ";
    
    foreach ($listAccount as $value) {
      $rank = $value['rank'];
      
      // Check Rank Gift
      $rank_gift = (new _PDO())->select($sql, array('rank' => $rank));
      if(empty($rank_gift))
        res(400, 'Hạng ['.$rank.'] chưa có phần thưởng tương ứng');
        
      // Check Gift
      $gifts = (array)json_decode((string)$rank_gift['gifts']);
      if(count($gifts) == 0)
        res(400, 'Hạng ['.$rank.'] chưa được cập nhật phần thưởng');
      
      // Set New List
      $list[] = array(
        'account' => $value['account'],
        'rank' => $rank,
        'items' => $gifts
      );
    }
    
    // Send
    foreach ($list as $value) {
      (new Game())->sendItems($value['account'], array(
        'server_id' => $server_id,
        'items' => $value['items']
      ));

      if($type == 'spend')
        $notify = 'Bạn nhận được quà xếp hạng ['.$value['rank'].'] Tiêu Phí tại máy chủ ['.$server_id.']';
      if($type == 'power')
        $notify = 'Bạn nhận được quà xếp hạng ['.$value['rank'].'] Lực Chiến tại máy chủ ['.$server_id.']';
      if($type == 'level')
        $notify = 'Bạn nhận được quà xếp hạng ['.$value['rank'].'] Cấp Độ tại máy chủ ['.$server_id.']';
      
      (new Notify())->create($value['account'], $notify, 'gifts');
    }
  }
}