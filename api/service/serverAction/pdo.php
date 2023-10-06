<?php
class ServerPDO {
  static $PDO_GetAllServerRankGift = "SELECT 
    * 
    FROM ny_server_rank_gift 
    WHERE server_id=:server_id 
    AND type=:type
    ORDER BY min ASC
  ";

  static $PDO_GetMaxServerRankGift = "SELECT 
    max 
    FROM ny_server_rank_gift 
    WHERE server_id=:server_id 
    AND type=:type
    ORDER BY max DESC LIMIT 1
  ";
}