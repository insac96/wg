<?php
require 'pdo.php';

class NewsUtils extends NewsPDO {
  /* Get News By ID */
  public function getNews ($id) {
    if(!is_numeric($id)) return res(400, 'Không tìm thấy ID tin tức');

    $news = (new _PDO())->select(self::$PDO_GetNews, array('id' => $id));

    if(empty($news)) return res(400, 'Tin tức không tồn tại');
    return $news;
  }
}