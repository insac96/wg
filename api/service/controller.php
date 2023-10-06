<?php
require_once API_DIR.'/payment/card/index.php';
require_once API_DIR.'/game/index.php';
require 'serverAction/index.php';
require 'notifyAction/index.php';
require 'configAction/index.php';
require 'adsAction/index.php';
require 'authAction/index.php';
require 'userAction/index.php';
require 'vipAction/index.php';
require 'newsAction/index.php';
require 'gateAction/index.php';
require 'payAction/index.php';
require 'withdrawAction/index.php';
require 'shopAction/index.php';
require 'eventAction/index.php';
require 'missionAction/index.php';
require 'wheelAction/index.php';
require 'diceAction/index.php';
require 'giftcodeAction/index.php';

class Controller {
/* Config */
  public function getConfig () {
    $config = (new Config())->getConfig();
    res(200, null, $config);
  }
/* End Config */

/* Ads */
  public function getAllAds () {
    $list = (new Ads())->getAllAds();
    res(200, null, $list);
  }
/* End Ads */

/* Auth */
  public function sign () {
    $sign = (new Auth())->sign();
    res(200, $sign['msg'], $sign['data']);
  }

  public function changePassword () {
    $authModel = new Auth();
    $user = $authModel->getAuth();
    $authModel->changePassword($user);
    res(200, 'Cập nhật mật khẩu thành công', $user);
  }

  public function updateAuthBank () {
    $authModel = new Auth();
    $user = $authModel->getAuth();
    $authModel->updateAuthBank($user);
    res(200, 'Cập nhật tài khoản rút tiền thành công', null);
  }

  public function updateAuthPhone () {
    $authModel = new Auth();
    $user = $authModel->getAuth();
    $authModel->updateAuthPhone($user);
    res(200, 'Cập nhật số điện thoại thành công', null);
  }
/* End Auth */

/* User */
  public function getUser () {
    $user = (new Auth())->getAuth();
    res(200, null, $user);
  }

  public function getAllInvitee () {
    $user = (new Auth())->getAuth();
    $list = (new User())->getAllInvitee($user);
    res(200, null, $list);
  }

  public function getAllUserEffect () {
    $user = (new Auth())->getAuth();
    $list = (new User())->getAllUserEffect($user);
    res(200, null, $list);
  }

  public function updateUserEffect () {
    $user = (new Auth())->getAuth();
    (new User())->updateUserEffect($user);
    
    res(200, 'Cập nhật thành công');
  }
/* End User */

/* News */
  public function getAllNews () {
    $list = (new News())->getAllNews();
    res(200, null, $list);
  }

  public function getNews () {
    $news = (new News())->getNews();
    res(200, null, $news);
  }
/* End News */

/* Shop */
  public function getShopRecharge () {
    $list = (new Shop())->getShopRecharge();
    res(200, null, $list);
  }

  public function getRecharge () {
    $recharge = (new Shop())->getRecharge($_POST['recharge_id']);
    res(200, null, $recharge);
  }

  public function buyRecharge () {
    $user = (new Auth())->getAuth();

    (new Shop())->buyRecharge($user);
    res(200, 'Mua gói thành công');
  }

  public function getShopItem () {
    $list = (new Shop())->getShopItem();
    res(200, null, $list);
  }

  public function buyItem () {
    $user = (new Auth())->getAuth();

    (new Shop())->buyItem($user);
    res(200, 'Mua vật phẩm thành công');
  }

  public function getShopCurrency () {
    $list = (new Shop())->getShopCurrency();
    res(200, null, $list);
  }

  public function buyCurrency () {
    $user = (new Auth())->getAuth();

    (new Shop())->buyCurrency($user);
    res(200, 'Mua tiền tệ thành công');
  }

  public function getShopEffect () {
    $list = (new Shop())->getShopEffect();
    res(200, null, $list);
  }

  public function buyEffect () {
    $user = (new Auth())->getAuth();

    (new Shop())->buyEffect($user);
    res(200, 'Mua hiệu ứng thành công');
  }
/* End Shop */

/* Gate */
  public function getAllGate () {
    $list = (new Gate())->getAllGate();
    res(200, null, $list);
  }
/* End Gate */

/* Pay */
  public function getAllPay () {
    $user = (new Auth())->getAuth();
    $list = (new Pay())->getAllPay($user);
    res(200, null, $list);
  }

  public function createPay () {
    $user = (new Auth())->getAuth();
    $pay = (new Pay())->createPay($user);
    res(200, null, $pay);
  }
/* End Pay */

/* Withdraw */
  public function getAllWithdraw () {
    $user = (new Auth())->getAuth();
    $list = (new Withdraw())->getAllWithdraw($user);
    res(200, null, $list);
  }

  public function withdrawMoney () {
    $user = (new Auth())->getAuth();
    (new Withdraw())->withdrawMoney($user);
    res(200, 'Rút tiền thành công, vui lòng đợi xét duyệt', null);
  }
/* End Withdraw */

/* Event */
  public function getAllEvent () {
    $list = (new Event())->getAllEvent();
    res(200, null, $list);
  }

  public function getAllMilestone () {
    $list = (new Event())->getAllMilestone();
    res(200, null, $list);
  }

  public function receiveMilestone () {
    $user = (new Auth())->getAuth();
    (new Event())->receiveMilestone($user);
    res(200, 'Nhận thưởng thành công');
  }
/* End Event */

/* Mission */
  public function getAllMission () {
    $list = (new Mission())->getAllMission();
    res(200, null, $list);
  }

  public function receiveMission () {
    $user = (new Auth())->getAuth();
    (new Mission())->receiveMission($user);
    res(200, 'Nhận thưởng thành công');
  }
/* End Mission */

/* Wheel */
  public function getWheel () {
    $wheel = (new Wheel())->getWheel();
    res(200, null, $wheel);
  }

  public function spinWheel () {
    $user = (new Auth())->getAuth();
    $gift = (new Wheel())->spinWheel($user);
    res(200, null, $gift);
  }
/* End Wheel */

/* Dice */
public function getDice () {
  $dice = (new Dice())->getDice();
  res(200, null, $dice);
}

public function shockDice () {
  $user = (new Auth())->getAuth();
  $result = (new Dice())->shockDice($user);
  res(200, null, $result);
}
/* End Dice */

/* Notify */
  public function getAllNotify () {
    $user = (new Auth())->getAuth();
    $list = (new Notify())->getAllNotify($user);
    res(200, null, $list);
  }
/* End Notify */

/* GiftCode */
  public function getGiftcode () {
    $user = (new Auth())->getAuth();
    $giftcode = (new Giftcode())->getGiftcode($user);
    res(200, 'Nhận thưởng thành công');
  }
/* End GiftCode */

/* VIP */
  public function getAllVip () {
    $list = (new Vip())->getAllVip();
    res(200, null, $list);
  }
/* End VIP */

/* Game */
  public function getAllServer () {
    $list = (new Game())->getAllServer();
    res(200, null, $list);
  }

  public function getRole () {
    $user = (new Auth())->getAuth();
    $role = (new Game())->getRole($user);
    res(200, null, $role);
  }

  public function loginGame () {
    $user = (new Auth())->getAuth();
    (new Game())->loginGame($user);
    res(200, 'Vào trò chơi thành công', null);
  }
/* End Game */

/* Server */
  public function getServerRank () {
    $list = (new Server())->getServerRank();
    res(200, null, $list);
  }
/* End Server */
}