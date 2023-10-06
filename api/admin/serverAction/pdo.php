<?php
class ServerPDO {
  static $PDO_GetAllServer = "SELECT * FROM ny_server";
  static $PDO_GetServer = "SELECT * FROM ny_server WHERE server_id=:server_id";
  static $PDO_DeleteServer = "DELETE FROM ny_server WHERE server_id=:server_id";

  static $PDO_GetServerRankGift = "SELECT * FROM ny_server_rank_gift WHERE id=:id";
  static $PDO_DeleteServerRankGift = "DELETE FROM ny_server_rank_gift WHERE id=:id";
}