<?php
require 'utils.php';

class News extends NewsUtils {
  /* Get All News */
  public function getAllNews () {
    if(empty($_POST['tab']) || $_POST['tab'] == 'all'){
      $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_news WHERE display=1", []);
      $count = $count['total'];
      return getTableList(null, self::$PDO_GetAllNews, $count);
    }
    else {
      $tab = (string)$_POST['tab'];
      $where = array('type' => $tab);
      $count = (new _PDO())->select("SELECT count(id) AS total FROM ny_news WHERE type=:type AND display=1", $where);
      $count = $count['total'];

      return getTableList(null, "SELECT 
        id, title, title_seo, description, img, update_time 
        FROM ny_news 
        WHERE type='$tab'
        AND display=1
      ", $count);
    }
  }

  /* Get News By Title Seo */
  public function getNews () {
    if(empty($_POST['title_seo'])) return res(400, 'Không tìm thấy tin tức');

    $news = (new _PDO())->select(self::$PDO_GetNews, array('title_seo' => $_POST['title_seo']));
    if(empty($news)) return res(400, 'Tin tức không tồn tại');

    (new _PDO())->update('ny_news', array(
      'viewer' => array('+', 1)
    ),
    array(
      'id' => $news['id']
    ));

    return $news;
  }
}