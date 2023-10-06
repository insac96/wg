<?php
require 'utils.php';
require 'ctvAction/index.php';
require 'configAction/index.php';
require 'serverAction/index.php';
require 'ipAction/index.php';
require 'statisticalAction/index.php';
require 'adsAction/index.php';
require 'vipAction/index.php';
require 'authAction/index.php';
require 'userAction/index.php';
require 'gateAction/index.php';
require 'payAction/index.php';
require 'withdrawAction/index.php';
require 'shopAction/index.php';
require 'newsAction/index.php';
require 'notifyAction/index.php';
require 'eventAction/index.php';
require 'missionAction/index.php';
require 'wheelAction/index.php';
require 'diceAction/index.php';
require 'giftcodeAction/index.php';
require 'giftAction/index.php';
require 'logAction/index.php';

class Controller {
/* Config */
  public function getConfig () {
    (new Auth())->getAuth(2);
    $config = (new Config())->getConfig();
    res(200, null, $config);
  }

  public function saveConfig () {
    (new Auth())->getAuth(2);
    (new Config())->saveConfig();
    res(200, 'Cập nhật thành công', null);
  }
/* End Config */

/* Server */
  public function getAllServer () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getAllServer();
    res(200, null, $list);
  }

  public function syncServer () {
    (new Auth())->getAuth(2);
    (new Server())->syncServer();
    res(200, 'Đồng bộ thành công', null);
  }

  public function deleteServer () {
    (new Auth())->getAuth(2);
    (new Server())->deleteServer();
    res(200, 'Tắt máy chủ thành công', null);
  }

  public function getLogServerLogin () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getLogServerLogin();
    res(200, null, $list);
  }

  public function getLogServerSpend () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getLogServerSpend();
    res(200, null, $list);
  }

  public function getServerRankSpend () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getServerRankSpend();
    res(200, null, $list);
  }

  public function getServerRankPower () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getServerRankPower();
    res(200, null, $list);
  }

  public function getServerRankLevel () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getServerRankLevel();
    res(200, null, $list);
  }

  public function getAllServerRankGift () {
    (new Auth())->getAuth(2);
    $list = (new Server())->getAllServerRankGift();
    res(200, null, $list);
  }

  public function updateServerRankGift () {
    (new Auth())->getAuth(2);
    (new Server())->updateServerRankGift();
    
    res(200, 'Cập nhật phần thưởng thành công');
  }

  public function createServerRankGift () {
    (new Auth())->getAuth(2);
    (new Server())->createServerRankGift();
    
    res(200, 'Tạo phần thưởng thành công');
  }

  public function deleteServerRankGift () {
    (new Auth())->getAuth(2);
    (new Server())->deleteServerRankGift();
    
    res(200, 'Xóa phần thưởng thành công');
  }

  public function sendRankGiftSpend () {
    (new Auth())->getAuth(2);
    (new Server())->sendRankGiftSpend();
    
    res(200, 'Gửi phần thưởng thành công');
  }

  public function sendRankGiftPower () {
    (new Auth())->getAuth(2);
    (new Server())->sendRankGiftPower();
    
    res(200, 'Gửi phần thưởng thành công');
  }

  public function sendRankGiftLevel () {
    (new Auth())->getAuth(2);
    (new Server())->sendRankGiftLevel();
    
    res(200, 'Gửi phần thưởng thành công');
  }
/* End Server */

/* IP Client */
  public function getAllIPClient () {
    (new Auth())->getAuth(2);
    $list = (new IPClient())->getAllIPClient();
    
    res(200, null, $list);
  }

  public function searchIPClient () {
    (new Auth())->getAuth(2);
    $list = (new IPClient())->searchIPClient();
    
    res(200, null, $list);
  }

  public function getAllAccountByIPClient () {
    (new Auth())->getAuth(2);
    $list = (new IPClient())->getAllAccountByIPClient();
    
    res(200, null, $list);
  }

  public function setBlockIP () {
    (new Auth())->getAuth(2);
    (new IPClient())->setBlockIP();
    res(200, 'Thao tác thành công');
  }
/* End IP Client */

/* User */
  public function getAllUser () {
    (new Auth())->getAuth(2);
    $list = (new User())->getAllUser();
    
    res(200, null, $list);
  }

  public function searchUser () {
    (new Auth())->getAuth(2);
    $list = (new User())->searchUser();
    
    res(200, null, $list);
  }

  public function getLogUserIP () {
    (new Auth())->getAuth(2);
    $list = (new User())->getLogUserIP();
    
    res(200, null, $list);
  }

  public function getLogUserReferral () {
    (new Auth())->getAuth(2);
    $list = (new User())->getLogUserReferral();
    
    res(200, null, $list);
  }
  
  public function updateUserAuth () {
    (new Auth())->getAuth(2);
    (new User())->updateUserAuth();
    
    res(200, 'Cập nhật tài khoản người dùng thành công');
  }

  public function updateUserInfo () {
    (new Auth())->getAuth(2);
    (new User())->updateUserInfo();
    
    res(200, 'Cập nhật tài khoản người dùng thành công');
  }

  public function updateUserPaySpend () {
    (new Auth())->getAuth(2);
    (new User())->updateUserPaySpend();
    
    res(200, 'Cập nhật tài khoản người dùng thành công');
  }

  public function updateUserMission () {
    (new Auth())->getAuth(2);
    (new User())->updateUserMission();
    
    res(200, 'Cập nhật tài khoản người dùng thành công');
  }

  public function sendItemToUser () {
    (new Auth())->getAuth(2);
    (new User())->sendItemToUser();
    
    res(200, 'Gửi vật phẩm thành công');
  }
/* End User */

/* Ads */
  public function getAllAds () {
    (new Auth())->getAuth(2);
    $list = (new Ads())->getAllAds();
    res(200, null, $list);
  }

  public function createAds () {
    (new Auth())->getAuth(2);
    (new Ads())->createAds();
    
    res(200, 'Tạo quảng cáo thành công');
  }

  public function updateAds () {
    (new Auth())->getAuth(2);
    (new Ads())->updateAds();
    
    res(200, 'Cập nhật quảng cáo thành công');
  }

  public function getAdsRevenue () {
    (new Auth())->getAuth(2);
    $list = (new Ads())->getAdsRevenue();
    res(200, null, $list);
  }

  public function getAdsSignUp () {
    (new Auth())->getAuth(2);
    $list = (new Ads())->getAdsSignUp();
    res(200, null, $list);
  }
/* End Ads */

/* News */
  public function getAllNews () {
    (new Auth())->getAuth(2);
    $list = (new News())->getAllNews();

    res(200, null, $list);
  }

  public function updateNews () {
    (new Auth())->getAuth(2);
    (new News())->updateNews();
    
    res(200, 'Cập nhật tin tức thành công');
  }

  public function createNews () {
    (new Auth())->getAuth(2);
    (new News())->createNews();
    
    res(200, 'Tạo tin tức thành công');
  }

  public function deleteNews () {
    (new Auth())->getAuth(2);
    (new News())->deleteNews();
    
    res(200, 'Xóa tin tức thành công');
  }
/* End News */

/* Gate */
  public function getAllGate () {
    (new Auth())->getAuth(2);
    $list = (new Gate())->getAllGate();
    res(200, null, $list);
  }

  public function updateGate () {
    (new Auth())->getAuth(2);
    (new Gate())->updateGate();
    
    res(200, 'Cập nhật kênh thanh toán thành công');
  }
/* End Gate */

/* Shop Recharge */
  public function getAllShopRecharge () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->getAllShopRecharge();
    
    res(200, null, $list);
  }

  public function searchShopRecharge () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->searchShopRecharge();

    res(200, null, $list);
  }

  public function updateShopRecharge () {
    (new Auth())->getAuth(2);
    (new Shop())->updateShopRecharge();
    
    res(200, 'Cập nhật gói thành công');
  }

  public function createShopRecharge () {
    (new Auth())->getAuth(2);
    (new Shop())->createShopRecharge();
    
    res(200, 'Tạo gói thành công');
  }

  public function deleteShopRecharge () {
    (new Auth())->getAuth(2);
    (new Shop())->deleteShopRecharge();
    
    res(200, 'Xóa gói thành công');
  }
/* End Shop Recharge*/

/* Shop Item */
  public function getAllShopItem () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->getAllShopItem();

    res(200, null, $list);
  }

  public function searchShopItem () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->searchShopItem();

    res(200, null, $list);
  }

  public function updateShopItem () {
    (new Auth())->getAuth(2);
    (new Shop())->updateShopItem();
    
    res(200, 'Cập nhật vật phẩm thành công');
  }

  public function createShopItem () {
    (new Auth())->getAuth(2);
    (new Shop())->createShopItem();
    
    res(200, 'Tạo vật phẩm thành công');
  }

  public function deleteShopItem () {
    (new Auth())->getAuth(2);
    (new Shop())->deleteShopItem();
    
    res(200, 'Xóa vật phẩm thành công');
  }
/* End Shop Item*/

/* Shop Currency */
  public function getAllShopCurrency () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->getAllShopCurrency();

    res(200, null, $list);
  }

  public function searchShopCurrency () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->searchShopCurrency();

    res(200, null, $list);
  }

  public function updateShopCurrency () {
    (new Auth())->getAuth(2);
    (new Shop())->updateShopCurrency();
    
    res(200, 'Cập nhật vật phẩm thành công');
  }

  public function createShopCurrency () {
    (new Auth())->getAuth(2);
    (new Shop())->createShopCurrency();
    
    res(200, 'Tạo vật phẩm thành công');
  }

  public function deleteShopCurrency () {
  (new Auth())->getAuth(2);
  (new Shop())->deleteShopCurrency();
  
  res(200, 'Xóa vật phẩm thành công');
  }
/* End Shop Currency*/

/* Shop Effect */
  public function getAllShopEffect () {
    (new Auth())->getAuth(2);
    $list = (new Shop())->getAllShopEffect();
    res(200, null, $list);
  }

  public function updateShopEffect () {
    (new Auth())->getAuth(2);
    (new Shop())->updateShopEffect();
    
    res(200, 'Cập nhật hiệu ứng thành công');
  }
/* End Shop Effect */

/* Pay */
  public function getAllPay () {
    (new Auth())->getAuth(2);
    $list = (new Pay())->getAllPay();
    
    res(200, null, $list);
  }

  public function searchPay () {
    (new Auth())->getAuth(2);
    $list = (new Pay())->searchPay();
    
    res(200, null, $list);
  }

  public function verifyPay () {
    $user = (new Auth())->getAuth(2);
    (new Pay())->verifyPay($user['account']);
    
    res(200, 'Thao tác thành công');
  }
/* End Pay */

/* Statistical */
  public function getStatisticalRevenue () {
    $user = (new Auth())->getAuth(2);
    $revenue = (new Statistical())->getStatisticalRevenue();

    res(200, null, $revenue);
  }

  public function getStatisticalTableRevenue () {
    $user = (new Auth())->getAuth(2);
    $list = (new Statistical())->getStatisticalTableRevenue();
    
    res(200, null, $list);
  }

  public function getStatisticalSignUp () {
    $user = (new Auth())->getAuth(2);
    $list = (new Statistical())->getStatisticalSignUp();
    
    res(200, null, $list);
  }

  public function getStatisticalSignIn () {
    $user = (new Auth())->getAuth(2);
    $list = (new Statistical())->getStatisticalSignIn();
    
    res(200, null, $list);
  }
/* End Statistical */

/* Withdraw */
  public function getAllWithdraw () {
    (new Auth())->getAuth(2);
    $list = (new Withdraw())->getAllWithdraw();
    
    res(200, null, $list);
  }

  public function searchWithdraw () {
    (new Auth())->getAuth(2);
    $list = (new Withdraw())->searchWithdraw();
    
    res(200, null, $list);
  }

  public function verifyWithdraw () {
    $user = (new Auth())->getAuth(2);
    (new Withdraw())->verifyWithdraw($user['account']);
    
    res(200, 'Thao tác thành công');
  }
/* End Withdraw */

/* Event */
  public function getAllEvent () {
    (new Auth())->getAuth(2);
    $list = (new Event())->getAllEvent();

    res(200, null, $list);
  }

  public function createEvent () {
    (new Auth())->getAuth(2);
    (new Event())->createEvent();
    
    res(200, 'Tạo sự kiện thành công');
  }

  public function updateEvent () {
    (new Auth())->getAuth(2);
    (new Event())->updateEvent();
    
    res(200, 'Cập nhật sự kiện thành công');
  }

  public function deleteEvent () {
    (new Auth())->getAuth(2);
    (new Event())->deleteEvent();
    
    res(200, 'Xóa sự kiện thành công');
  }
/* End Event */

/* Event Milestone */
  public function getAllEventMilestone () {
    (new Auth())->getAuth(2);
    $list = (new Event())->getAllEventMilestone();

    res(200, null, $list);
  }

  public function updateEventMilestone () {
    (new Auth())->getAuth(2);
    (new Event())->updateEventMilestone();
    
    res(200, 'Cập nhật mốc thưởng thành công');
  }

  public function createEventMilestone () {
    (new Auth())->getAuth(2);
    (new Event())->createEventMilestone();
    
    res(200, 'Tạo mốc thưởng thành công');
  }

  public function deleteEventMilestone () {
    (new Auth())->getAuth(2);
    (new Event())->deleteEventMilestone();
    
    res(200, 'Xóa mốc thưởng thành công');
  }
/* End Event Milestone */

/* Mission */
  public function getAllMission () {
    (new Auth())->getAuth(2);
    $list = (new Mission())->getAllMission();

    res(200, null, $list);
  }

  public function createMission () {
    (new Auth())->getAuth(2);
    (new Mission())->createMission();
    
    res(200, 'Tạo nhiệm vụ thành công');
  }

  public function updateMission () {
    (new Auth())->getAuth(2);
    (new Mission())->updateMission();
    
    res(200, 'Sửa nhiệm vụ thành công');
  }

  public function deleteMission () {
    (new Auth())->getAuth(2);
    (new Mission())->deleteMission();
    
    res(200, 'Xóa nhiệm vụ thành công');
  }
/* End Mission */

/* Wheel */
  public function getAllWheelGift () {
    (new Auth())->getAuth(2);
    $list = (new Wheel())->getAllWheelGift();

    res(200, null, $list);
  }

  public function updateWheelGift () {
    (new Auth())->getAuth(2);
    (new Wheel())->updateWheelGift();
    
    res(200, 'Cập nhật phần thưởng thành công');
  }

  public function createWheelGift () {
    (new Auth())->getAuth(2);
    (new Wheel())->createWheelGift();
    
    res(200, 'Tạo phần thưởng thành công');
  }

  public function deleteWheelGift () {
    (new Auth())->getAuth(2);
    (new Wheel())->deleteWheelGift();
    
    res(200, 'Xóa phần thưởng thành công');
  }
/* End Wheel */

/* Dice */
public function getDiceConfig () {
  (new Auth())->getAuth(2);
  $config = (new Dice())->getDiceConfig();
  res(200, null, $config);
}

public function updateDiceConfig () {
  (new Auth())->getAuth(2);
  (new Dice())->updateDiceConfig();
  res(200, 'Cập nhật thành công', null);
}
/* End Config */

/* Giftcode */
  public function getAllGiftcode () {
    (new Auth())->getAuth(2);
    $list = (new Giftcode())->getAllGiftcode();

    res(200, null, $list);
  }

  public function createGiftcode () {
    (new Auth())->getAuth(2);
    (new Giftcode())->createGiftcode();
    
    res(200, 'Tạo Giftcode thành công');
  }

  public function updateGiftcode () {
    (new Auth())->getAuth(2);
    (new Giftcode())->updateGiftcode();
    
    res(200, 'Sửa Giftcode thành công');
  }

  public function deleteGiftcode () {
    (new Auth())->getAuth(2);
    (new Giftcode())->deleteGiftcode();
    
    res(200, 'Xóa Giftcode thành công');
  }
/* End Giftcode */

/* VIP */
  public function getAllVip () {
    (new Auth())->getAuth(2);
    $list = (new Vip())->getAllVip();
    res(200, null, $list);
  }

  public function updateVip () {
    (new Auth())->getAuth(2);
    (new Vip())->updateVip();
    
    res(200, 'Cập nhật cấp VIP thành công');
  }
/* End VIP */

/* Gift */
  public function getAllGift () {
    (new Auth())->getAuth(2);
    $list = (new Gift())->getAllGift();

    res(200, null, $list);
  }

  public function getAllGiftSelect () {
    (new Auth())->getAuth(2);
    $list = (new Gift())->getAllGift(true);
    res(200, null, $list);
  }

  public function createGift () {
    (new Auth())->getAuth(2);
    (new Gift())->createGift();
    
    res(200, 'Tạo bộ quà tặng thành công');
  }

  public function updateGift () {
    (new Auth())->getAuth(2);
    (new Gift())->updateGift();
    
    res(200, 'Sửa bộ quà tặng thành công');
  }

  public function deleteGift () {
    (new Auth())->getAuth(2);
    (new Gift())->deleteGift();
    
    res(200, 'Xóa bộ quà tặng thành công');
  }
/* End Gift */

/* Log */
  public function searchLog () {
    (new Auth())->getAuth(2);
    $list = (new Log())->searchLog();

    res(200, null, $list);
  }

  public function getAllLogAdmin () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogAdmin();
    
    res(200, null, $list);
  }

  public function getAllLogShop () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogShop();
    
    res(200, null, $list);
  }

  public function getAllLogEvent () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogEvent();
    
    res(200, null, $list);
  }

  public function getAllLogMission () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogMission();
    
    res(200, null, $list);
  }

  public function getAllLogWheel () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogWheel();
    
    res(200, null, $list);
  }

  public function getAllLogDice () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogDice();
    
    res(200, null, $list);
  }

  public function getAllLogGiftcode () {
    (new Auth())->getAuth(2);
    $list = (new Log())->getAllLogGiftcode();
    
    res(200, null, $list);
  }
/* End Log */

/* ADMIN */
  public function getStatisticalRevenue_ADMIN () {
    $revenue = (new Statistical())->getStatisticalRevenue();
    res(200, null, $revenue);
  }

  public function getStatisticalTableRevenue_ADMIN () {
    $list = (new Statistical())->getStatisticalTableRevenue();
    res(200, null, $list);
  }

  public function getStatisticalSignUp_ADMIN () {
    $list = (new Statistical())->getStatisticalSignUp();
    res(200, null, $list);
  }

  public function getStatisticalSignIn_ADMIN () {
    $list = (new Statistical())->getStatisticalSignIn();
    res(200, null, $list);
  }

  public function getAllCTV_ADMIN () {
    $list = (new CTV())->getAllCTV();
    res(200, null, $list);
  }

  public function searchCTV_ADMIN () {
    $list = (new CTV())->searchCTV();
    res(200, null, $list);
  }

  public function getLogCTVReferral_ADMIN () {
    $list = (new CTV())->getLogCTVReferral();
    res(200, null, $list);
  }

  public function getAllLogAdmin_ADMIN () {
    $list = (new Log())->getAllLogAdmin();
    res(200, null, $list);
  }
/* END ADMIN */
}
