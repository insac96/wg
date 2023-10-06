<?php
class NewsPDO {
  static $PDO_GetAllNews = "SELECT 
    id, title, title_seo, description, img, update_time 
    FROM ny_news 
    WHERE display='1' 
  ";
  
  static $PDO_GetNews = "SELECT * FROM ny_news WHERE display='1' AND title_seo=:title_seo";
}