<?php
require 'utils.php';

class Shop extends ShopUtils {
  /* Get All Shop Recharge */
  public function getAllShopRecharge () {
    return getTableList('ny_shop_recharge', self::$PDO_GetAllShopRecharge);
  }

  /* Search Recharge */
  public function searchShopRecharge () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_shop_recharge 
      WHERE id LIKE :query 
      OR name LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_shop_recharge 
      WHERE id LIKE :query 
      OR name LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Create Shop Recharge */
  public function createShopRecharge () {
    if(
      empty($_POST['name']) 
      || !is_numeric($_POST['price']) 
      || !is_numeric($_POST['max']) 
      || !is_numeric($_POST['save_pay_ingame'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check Has RechargeID
    if($this->getRecharge($_POST['id'], true))
      return res(400, 'ID Gói đã tồn tại');

    // Create
    (new _PDO())->create('ny_shop_recharge', array(
      'id' => (int)$_POST['id'],
      'name' => (string)$_POST['name'],
      'price' => (int)$_POST['price'],
      'save_pay_ingame' => (int)$_POST['save_pay_ingame'],
      'max' => (int)$_POST['max'],
      'icon' => (string)$_POST['icon'],
      'display' => (int)$_POST['display'],
      'update_time' => time()
    ));

    // Log
    logAdmin('Tạo gói ['.$_POST['name'].'] trong cửa hàng');
  }
  
   /* Update Shop Recharge */
  public function updateShopRecharge () {
    if(
      !is_numeric($_POST['id']) 
      || empty($_POST['name'])
      || !is_numeric($_POST['max']) 
      || !is_numeric($_POST['price']) 
      || !is_numeric($_POST['save_pay_ingame'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Recharge
    $recharge = $this->getRecharge($_POST['id']);

    // Update
    (new _PDO())->update('ny_shop_recharge',
      array(
        'name' => (string)$_POST['name'],
        'price' => (int)$_POST['price'],
        'save_pay_ingame' => (int)$_POST['save_pay_ingame'],
        'max' => (int)$_POST['max'],
        'icon' => (string)$_POST['icon'],
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array(
        'id' => $recharge['id']
      )
    );

    // Log
    logAdmin('Cập nhật gói ['.$recharge['name'].'] trong cửa hàng');
  }

  /* Delete Shop Recharge */
  public function deleteShopRecharge () {
    $recharge = $this->getRecharge($_POST['recharge_id']);

    (new _PDO())->delete(self::$PDO_DeleteRecharge, array('id' => $recharge['id']));
    logAdmin('Xóa gói ['.$recharge['name'].'] trong cửa hàng');
  }

  /* Get All Shop Item */
  public function getAllShopItem () {
    return getTableList('ny_shop_item', self::$PDO_GetAllShopItem);
  }

  /* Search Item */
  public function searchShopItem () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_shop_item 
      WHERE id LIKE :query 
      OR name LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_shop_item 
      WHERE id LIKE :query 
      OR name LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Create Shop Item */
  public function createShopItem () {
    if(
      empty($_POST['name']) 
      || !is_numeric($_POST['price']) 
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check Has ItemID
    if($this->getItem($_POST['id'], true))
      return res(400, 'ID Vật phẩm đã tồn tại');

    // Create
    (new _PDO())->create('ny_shop_item', array(
      'id' => (int)$_POST['id'],
      'name' => (string)$_POST['name'],
      'price' => (int)$_POST['price'],
      'icon' => (string)$_POST['icon'],
      'display' => (int)$_POST['display'],
      'update_time' => time()
    ));

    // Log
    logAdmin('Tạo vật phẩm ['.$_POST['name'].'] trong cửa hàng');
  }

  /* Update Shop Item */
  public function updateShopItem () {
    if(
      !is_numeric($_POST['id']) 
      || empty($_POST['name']) 
      || !is_numeric($_POST['price']) 
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Item
    $item = $this->getItem($_POST['id']);

    // Update
    (new _PDO())->update('ny_shop_item',
      array(
        'name' => (string)$_POST['name'],
        'price' => (int)$_POST['price'],
        'icon' => (string)$_POST['icon'],
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array('id' => $item['id'])
    );    

    // Log
    logAdmin('Cập nhật vật phẩm ['.$item['name'].'] trong cửa hàng');
  }

  /* Delete Shop Item */
  public function deleteShopItem () {
    $item = $this->getItem($_POST['item_id']);

    (new _PDO())->delete(self::$PDO_DeleteItem, array('id' => (int)$item['id']));
    logAdmin('Xóa vật phẩm ['.$item['name'].'] trong cửa hàng');
  }

  /* Get All Shop Currency */
  public function getAllShopCurrency () {
    return getTableList('ny_shop_currency', self::$PDO_GetAllShopCurrency);
  }

  /* Search Currency */
  public function searchShopCurrency () {
    $sqlCount = "SELECT 
      count(id) AS total 
      FROM ny_shop_currency 
      WHERE id LIKE :query 
      OR name LIKE :query
    ";

    $sqlSearch = "SELECT *
      FROM ny_shop_currency 
      WHERE id LIKE :query 
      OR name LIKE :query
    ";

    return getTableSearch($sqlCount, $sqlSearch);
  }

  /* Create Shop Currency */
  public function createShopCurrency () {
    if(
      empty($_POST['name']) 
      || empty($_POST['type']) 
      || empty($_POST['buy_with']) 
      || !is_numeric($_POST['price']) 
      || !is_numeric($_POST['amount'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');

    // Check Type
    if($_POST['type'] == $_POST['buy_with'])
      res(400, '2 loại tiền tệ không thể giống nhau');
    
    // Create
    (new _PDO())->create('ny_shop_currency', array(
      'name' => (string)$_POST['name'],
      'type' => (string)$_POST['type'],
      'buy_with' => (string)$_POST['buy_with'],
      'price' => (int)$_POST['price'],
      'amount' => (int)$_POST['amount'],
      'icon' => (string)$_POST['icon'],
      'display' => (int)$_POST['display'],
      'update_time' => time()
    ));

    // Log
    logAdmin('Tạo gói tiền tệ ['.$_POST['name'].'] trong cửa hàng');
  }

  /* Update Shop Currency */
  public function updateShopCurrency () {
    if(
      !is_numeric($_POST['id']) 
      || empty($_POST['name']) 
      || empty($_POST['type']) 
      || empty($_POST['buy_with']) 
      || !is_numeric($_POST['price']) 
      || !is_numeric($_POST['amount'])
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check Type
    if($_POST['type'] == $_POST['buy_with'])
      res(400, '2 loại tiền tệ không thể giống nhau');

    // Check Currency
    $currency = $this->getCurrency($_POST['id']);

    // Update
    (new _PDO())->update('ny_shop_currency',
      array(
        'name' => (string)$_POST['name'],
        'type' => (string)$_POST['type'],
        'buy_with' => (string)$_POST['buy_with'],
        'price' => (int)$_POST['price'],
        'amount' => (int)$_POST['amount'],
        'icon' => (string)$_POST['icon'],
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array('id' => $currency['id'])
    );    

    // Log
    logAdmin('Cập nhật gói tiền tệ ['.$currency['name'].'] trong cửa hàng');
  }

  /* Delete Shop Currency */
  public function deleteShopCurrency () {
    $currency = $this->getCurrency($_POST['currency_id']);

    (new _PDO())->delete(self::$PDO_DeleteCurrency, array('id' => (int)$currency['id']));
    logAdmin('Xóa gói tiền tệ ['.$currency['name'].'] trong cửa hàng');
  }

  /* Get All Shop Effect */
  public function getAllShopEffect () {
    return getTableList('ny_shop_effect', self::$PDO_GetAllShopEffect);
  }

  /* Update Shop Effect */
  public function updateShopEffect () {
    if(
      !is_numeric($_POST['id']) 
      || empty($_POST['name']) 
      || !is_numeric($_POST['price']) 
      || !is_numeric($_POST['display'])
    ) return res(400, 'Dữ liệu đầu vào không đủ');
    
    // Check Effect
    $effect = $this->getEffect($_POST['id']);

    // Update
    (new _PDO())->update('ny_shop_effect',
      array(
        'name' => (string)$_POST['name'],
        'price' => (int)$_POST['price'],
        'display' => (int)$_POST['display'],
        'update_time' => time()
      ),
      array('id' => $effect['id'])
    );    

    // Log
    logAdmin('Cập nhật hiệu ứng ['.$effect['name'].'] trong cửa hàng');
  }
}