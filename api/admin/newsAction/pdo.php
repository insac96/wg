<?php
class NewsPDO {
  static $PDO_GetAllNews = "SELECT * FROM ny_news";
  static $PDO_GetNews = "SELECT * FROM ny_news WHERE id=:id";
  static $PDO_DeleteNews = "DELETE FROM ny_news WHERE id=:id";
}