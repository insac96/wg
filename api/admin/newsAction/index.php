<?php
require 'utils.php';

class News extends NewsUtils {
  /* Get All News */
  public function getAllNews () {
    return getTableList('ny_news', self::$PDO_GetAllNews);
  }

  /* Update News */
  public function updateNews () {
    if(
      empty($_POST['title']) 
      || empty($_POST['title_seo']) 
      || empty($_POST['description']) 
      || empty($_POST['content'])
      || empty($_POST['type']) 
      || !is_numeric($_POST['display'])
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Check News
    $news = $this->getNews($_POST['id']);

    // Update
    (new _PDO())->update('ny_news', 
      array(
        'title' => (string)$_POST['title'],
        'title_seo' => (string)$_POST['title_seo'],
        'description' => (string)$_POST['description'],
        'content' => (string)$_POST['content'],
        'type' => (string)$_POST['type'],
        'img' => (string)$_POST['img'],
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ), 
      array('id'=>$news['id'])
    );

    logAdmin('Cập nhật tin tức ['.$news['title'].']');
  }

  /* Create News */
  public function createNews () {
    if(
      empty($_POST['title']) 
      || empty($_POST['title_seo']) 
      || empty($_POST['description']) 
      || empty($_POST['content'])
      || empty($_POST['type']) 
      || !is_numeric($_POST['display'])
    )
      res(400, 'Dữ liệu đầu vào không đủ');

    // Create
    (new _PDO())->create('ny_news', array(
      'title' => (string)$_POST['title'],
      'title_seo' => (string)$_POST['title_seo'],
      'description' => (string)$_POST['description'],
      'content' => (string)$_POST['content'],
      'type' => (string)$_POST['type'],
      'img' => (string)$_POST['img'],
      'display' => (int)$_POST['display'],
      'update_time' => time()
    ));

    logAdmin('Tạo tin tức mới ['.$_POST['title'].']');
  }

  /* Delete News */
  public function deleteNews () {
    $news = $this->getNews($_POST['news_id']);

    (new _PDO())->delete(self::$PDO_DeleteNews, array('id' => $news['id']));
    logAdmin('Xóa tin tức ['.$news['title'].']');
  }
}