SET FOREIGN_KEY_CHECKS=0;

/* Config */
DROP TABLE IF EXISTS `ny_config`;
CREATE TABLE `ny_config` (
`game_name` varchar(1000) NOT NULL,
`game_info` text,
`game_icon_path` varchar(1000),
`game_banner` varchar(1000),
`game_logo` varchar(1000),
`web_link` varchar(1000),
`fanpage_link` varchar(1000),
`group_link` varchar(1000),
`messenger_link` varchar(1000),
`zalo_link` varchar(1000),
`telegram_link` varchar(1000),
`phone_support` varchar(1000),
`email_support` varchar(1000),
`api_key_card` varchar(1000),
`url_callback_card` varchar(1000) DEFAULT '/api/payment/card/callback.php',
`api_key_momo` varchar(1000),
`url_callback_momo` varchar(1000) DEFAULT '/api/payment/momo/callback.php',
`api_key_banking` varchar(1000),
`url_callback_banking` varchar(1000) DEFAULT '/api/payment/banking/callback.php',
`prefix_pay` varchar(50),
`prefix_withdraw` varchar(50),
`prefix_referral` varchar(50),
`coin_reg` double(50,0) unsigned DEFAULT 0,
`coin_lock_reg` double(50,0) unsigned DEFAULT 0
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `ny_config` (`game_name`) VALUES ('Website');


/* VIP */
DROP TABLE IF EXISTS `ny_vip`;
CREATE TABLE `ny_vip` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`number` int(11) NOT NULL DEFAULT 0,
`need_exp` double(50,0) unsigned DEFAULT 0,
`discount_shop` int(11) NOT NULL DEFAULT 0 COMMENT 'percent of price',
`pay_bonus` int(11) NOT NULL DEFAULT 0 COMMENT 'percent of pay',
`referral_pay_bonus` int(11) NOT NULL DEFAULT 0 COMMENT 'percent of pay',
`referral_bonus_coin` double(50,0) unsigned NOT NULL DEFAULT 0 COMMENT 'money',
`pay_to_wheel` double(50,0) unsigned NOT NULL DEFAULT 0 COMMENT '? Pay = 1 Wheel',
`diamond_to_money` double(50,0) unsigned NOT NULL DEFAULT 0 COMMENT '1 Diamond = ? Money',
`max_invite` int(11) NOT NULL DEFAULT 0 COMMENT 'max invite',
`max_spin_wheel` int(11) NOT NULL DEFAULT 0 COMMENT 'max spin wheel',
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_vip` VALUES (1, 0, 0, 0, 0, 1, 0, 20000, 0, 0, 500);
INSERT INTO `ny_vip` VALUES (2, 1, 500000, 2, 2, 2, 0, 20000, 1, 5, 1000);
INSERT INTO `ny_vip` VALUES (3, 2, 2000000, 5, 5, 5, 0, 20000, 1, 10, 1500);
INSERT INTO `ny_vip` VALUES (4, 3, 4000000, 5, 5, 5, 0, 20000, 1, 15, 2000);
INSERT INTO `ny_vip` VALUES (5, 4, 8000000, 10, 10, 10, 5000, 15000, 1, 20, 2500);
INSERT INTO `ny_vip` VALUES (6, 5, 15000000, 10, 10, 10, 5000, 15000, 1, 25, 3000);
INSERT INTO `ny_vip` VALUES (7, 6, 30000000, 15, 15, 15, 10000, 15000, 1, 30, 3500);
INSERT INTO `ny_vip` VALUES (8, 7, 50000000, 15, 15, 15, 10000, 10000, 1, 35, 4000);
INSERT INTO `ny_vip` VALUES (9, 8, 100000000, 20, 20, 20, 20000, 10000, 1, 40, 4500);
INSERT INTO `ny_vip` VALUES (10, 9, 150000000, 20, 20, 20, 20000, 5000, 1, 45, 5000);
INSERT INTO `ny_vip` VALUES (11, 10, 200000000, 25, 25, 25, 30000, 5000, 1, 50, 5500);
INSERT INTO `ny_vip` VALUES (12, 11, 300000000, 30, 30, 30, 40000, 5000, 1, 55, 6000);
INSERT INTO `ny_vip` VALUES (13, 12, 400000000, 30, 30, 30, 50000, 5000, 1, 60, 6500);
INSERT INTO `ny_vip` VALUES (14, 13, 500000000, 35, 35, 35, 60000, 5000, 1, 65, 7000);
INSERT INTO `ny_vip` VALUES (15, 14, 600000000, 35, 35, 35, 70000, 5000, 1, 70, 7500);
INSERT INTO `ny_vip` VALUES (16, 15, 700000000, 35, 35, 35, 80000, 5000, 1, 75, 8000);
INSERT INTO `ny_vip` VALUES (17, 16, 800000000, 40, 40, 40, 90000, 5000, 1, 80, 8500);
INSERT INTO `ny_vip` VALUES (18, 17, 900000000, 40, 40, 40, 100000, 5000, 1, 85, 9000);
INSERT INTO `ny_vip` VALUES (19, 18, 1000000000, 40, 40, 40, 110000, 5000, 1, 90, 9500);
INSERT INTO `ny_vip` VALUES (20, 19, 1100000000, 40, 40, 40, 120000, 5000, 1, 95, 10000);
INSERT INTO `ny_vip` VALUES (21, 20, 1200000000, 45, 45, 45, 130000, 5000, 2, 100, 11000);
INSERT INTO `ny_vip` VALUES (22, 21, 1300000000, 45, 45, 45, 140000, 5000, 2, 110, 12000);
INSERT INTO `ny_vip` VALUES (23, 22, 1400000000, 45, 45, 45, 150000, 4000, 2, 120, 13000);
INSERT INTO `ny_vip` VALUES (24, 23, 1500000000, 45, 45, 45, 200000, 3000, 2, 130, 14000);
INSERT INTO `ny_vip` VALUES (25, 24, 1600000000, 50, 50, 50, 250000, 2000, 2, 140, 15000);

/* Auth */
DROP TABLE IF EXISTS `ny_auth`;
CREATE TABLE `ny_auth` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`phone` varchar(15),
`block` tinyint(3) unsigned DEFAULT 0 COMMENT '0: Unblock, 1: Block',
`type` tinyint(3) unsigned DEFAULT 0 COMMENT '0: Member, 1: Smod, 2: Admin',
`token` varchar(2000),
`referral_code` varchar(100),
`referraler` varchar(100),
`bank_name` varchar(100),
`bank_person` varchar(100),
`bank_stk` varchar(50),
`reg_from` int(11) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_auth` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', null, 0, 2, null, null, null, null, null, null, 0);

/* User */
DROP TABLE IF EXISTS `ny_user`;
CREATE TABLE `ny_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`vip` int(11) NOT NULL DEFAULT 0,
`vip_exp` double(50,0) unsigned DEFAULT 0,
`login_day` int(11) DEFAULT 0,
`coin` double(50,0) unsigned DEFAULT 0,
`coin_lock` double(50,0) unsigned DEFAULT 0,
`diamond` double(50,0) unsigned DEFAULT 0,
`wheel` double(50,0) unsigned DEFAULT 0,
`spend_day` double(50,0) DEFAULT 0,
`spend_month` double(50,0) DEFAULT 0,
`spend_all` double(50,0) DEFAULT 0,
`pay_day` double(50,0) DEFAULT 0,
`pay_month` double(50,0) DEFAULT 0,
`pay_all` double(50,0) DEFAULT 0,
`spin_wheel_count` double(50,0) DEFAULT 0,
`referral_count` double(50,0) DEFAULT 0,
`create_time` int(11) unsigned NOT NULL DEFAULT 0,
`join_group` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '0: False, 1: True',
`join_zalo` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '0: False, 1: True',
`join_telegram` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '0: False, 1: True',
`effect` varchar(100) NOT NULL DEFAULT 'vip',
`date` varchar(20) NOT NULL DEFAULT '',
`month` varchar(20) NOT NULL DEFAULT '',
`year` varchar(20) NOT NULL DEFAULT '',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_user` (`account`) VALUES ('admin');

/* Log Referral */
DROP TABLE IF EXISTS `ny_log_referral`;
CREATE TABLE `ny_log_referral` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`invitee` varchar(100) NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Notify */
DROP TABLE IF EXISTS `ny_notify`;
CREATE TABLE `ny_notify` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`type` varchar(100) NOT NULL,
`content` text,
`view` tinyint(3) unsigned DEFAULT 0,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Gate */
DROP TABLE IF EXISTS `ny_gate`;
CREATE TABLE `ny_gate` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`type` tinyint(10) unsigned NOT NULL COMMENT '1: Banking, 2: Card, 3: Momo',
`name` varchar(100) NOT NULL,
`person` varchar(100) NOT NULL,
`stk` varchar(50) NOT NULL,
`icon` varchar(2000),
`qr_link` varchar(2000),
`bonus_default` int(11) NOT NULL DEFAULT 0,
`bonus` int(11) NOT NULL DEFAULT 0,
`expires_bonus` int(11) unsigned DEFAULT 0,
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_gate` VALUES (1, 1, 'Banking', 'System', 'System', null, 'https://img.vietqr.io/image/[bankcode]-[stk]-print.png', 0, 0, 0, 1, 0);
INSERT INTO `ny_gate` VALUES (2, 2, 'Card', 'System', 'System', null, null, 0, 0, 0, 1, 0);
INSERT INTO `ny_gate` VALUES (3, 3, 'Momo', 'System', 'System', null, 'https://momosv3.apimienphi.com/api/QRCode', 0, 0, 0, 1, 0);


/* Event */
DROP TABLE IF EXISTS `ny_event`;
CREATE TABLE `ny_event` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(2000) NOT NULL,
`info` text,
`type` varchar(50) NOT NULL,
`icon` varchar(2000),
`milestone_type` varchar(50) NOT NULL,
`comparison` varchar(50) NOT NULL,
`prefix` varchar(50) DEFAULT '',
`suffix` varchar(50) DEFAULT '',
`expires_time` int(11) unsigned DEFAULT 0,
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_event` VALUES (1, 'Đăng nhập ngày', '', 'login_day', null, 'number', '>=', 'Ngày', '', 0, 1, 0);
INSERT INTO `ny_event` VALUES (2, 'Tích nạp ngày', '', 'pay_day', null, 'money', '>=', 'Nạp', 'VNĐ', 0, 1, 0);
INSERT INTO `ny_event` VALUES (3, 'Tích nạp tháng', '', 'pay_month', null, 'money', '>=', 'Nạp', 'VNĐ', 0, 1, 0);
INSERT INTO `ny_event` VALUES (4, 'Tích nạp', '', 'pay_all', null, 'money', '>=', 'Nạp', 'VNĐ', 0, 1, 0);
INSERT INTO `ny_event` VALUES (5, 'Tiêu phí ngày', '', 'spend_day', null, 'money', '>=', 'Tiêu', 'Xu', 0, 1, 0);
INSERT INTO `ny_event` VALUES (6, 'Tiêu phí tháng', '', 'spend_month', null, 'money', '>=', 'Tiêu', 'Xu', 0, 1, 0);
INSERT INTO `ny_event` VALUES (7, 'Tiêu phí', '', 'spend_all', null, 'money', '>=', 'Tiêu', 'Xu', 0, 1, 0);

DROP TABLE IF EXISTS `ny_event_milestone`;
CREATE TABLE `ny_event_milestone` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`event_id` int(11) NOT NULL,
`need` double(50,0) unsigned NOT NULL,
`gifts` text,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ny_log_event`;
CREATE TABLE `ny_log_event` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`server_id` varchar(100) NOT NULL,
`event_id` int(11) NOT NULL,
`milestone_id` int(11) NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Mission */
DROP TABLE IF EXISTS `ny_mission`;
CREATE TABLE `ny_mission` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(1000) NOT NULL,
`info` text,
`type` varchar(50) NOT NULL,
`need` double(50,0) unsigned NOT NULL,
`icon` varchar(2000),
`gifts` text,
`expires_time` int(11) unsigned DEFAULT 0,
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ny_log_mission`;
CREATE TABLE `ny_log_mission` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`server_id` varchar(100) NOT NULL,
`mission_id` int(11) NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Mission Custom */
DROP TABLE IF EXISTS `ny_mission_custom`;
CREATE TABLE `ny_mission_custom` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(1000) NOT NULL,
`info` text,
`gifts` text,
`expires_time` int(11) unsigned DEFAULT 0,
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* New */
DROP TABLE IF EXISTS `ny_news`;
CREATE TABLE `ny_news` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(2000) NOT NULL,
`title_seo` varchar(2000) NOT NULL,
`description` text,
`content` text,
`type` varchar(50) NOT NULL,
`img` varchar(2000),
`viewer` int(11) NOT NULL DEFAULT 0,
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Pay */
DROP TABLE IF EXISTS `ny_pay`;
CREATE TABLE `ny_pay` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`money` double(50,0) unsigned NOT NULL,
`gate_id` int(11) NOT NULL,
`code` varchar(50),
`token` varchar(2000) NOT NULL,
`qr` text,
`status` tinyint(3) unsigned DEFAULT 0 COMMENT '0: Wait, 1: Done, 2: Error',
`verifier` varchar(100),
`verify_time` int(11) unsigned,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Withdraw */
DROP TABLE IF EXISTS `ny_withdraw`;
CREATE TABLE `ny_withdraw` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`diamond` double(50,0) unsigned NOT NULL,
`money` double(50,0) unsigned NOT NULL,
`code` varchar(50),
`token` varchar(2000) NOT NULL,
`status` tinyint(3) unsigned DEFAULT 0 COMMENT '0: Wait, 1: Done, 2: Error',
`verifier` varchar(100),
`verify_time` int(11) unsigned,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_shop_recharge`;
CREATE TABLE `ny_shop_recharge` (
`id` int(11) NOT NULL,
`name` varchar(2000) NOT NULL,
`price` double(50,0) unsigned NOT NULL,
`max` double(50,0) unsigned NOT NULL DEFAULT 0,
`save_pay_ingame` double(50,0) unsigned DEFAULT 0,
`icon` varchar(2000),
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_shop_item`;
CREATE TABLE `ny_shop_item` (
`id` int(11) NOT NULL,
`name` varchar(2000) NOT NULL,
`price` double(50,0) unsigned NOT NULL,
`amount` int(11) NOT NULL DEFAULT 1,
`icon` varchar(2000),
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_shop_currency`;
CREATE TABLE `ny_shop_currency` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(2000) NOT NULL,
`type` varchar(50) NOT NULL,
`price` double(50,0) unsigned NOT NULL,
`amount` int(11) NOT NULL,
`buy_with` varchar(50) NOT NULL,
`icon` varchar(2000),
`display` tinyint(3) unsigned NOT NULL COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_shop_currency` VALUES (1, '1 Vòng Quay', 'wheel', 50000, 1, 'coin_lock', null, 1, 0);


DROP TABLE IF EXISTS `ny_shop_effect`;
CREATE TABLE `ny_shop_effect` (
`id` int(11) NOT NULL,
`name` varchar(2000) NOT NULL,
`price` double(50,0) unsigned NOT NULL,
`type` varchar(100),
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_shop_effect` VALUES (1, 'Huyền Long', 100000, 'dragon-blue', 1, 0);
INSERT INTO `ny_shop_effect` VALUES (2, 'Ngọc Long', 100000, 'dragon-green', 1, 0);
INSERT INTO `ny_shop_effect` VALUES (3, 'Huyết Long', 100000, 'dragon-red', 1, 0);


DROP TABLE IF EXISTS `ny_log_shop`;
CREATE TABLE `ny_log_shop` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`server_id` varchar(100) NOT NULL,
`shop_id` int(11) NOT NULL,
`shop_type` varchar(100) NOT NULL,
`price` double(50,0) unsigned NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_wheel_gift`;
CREATE TABLE `ny_wheel_gift` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`type` varchar(100) NOT NULL,
`amount` double(50,0) unsigned NOT NULL,
`percent` FLOAT NOT NULL,
`display` tinyint(3) unsigned NOT NULL COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
`item_id` int(11),
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_wheel_gift` VALUES (1, 'Mất lượt', 'unlucky', 0, '0.95', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (2, '10K Xu', 'coin', 10000, '0.5', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (3, '10K Xu khóa', 'coin_lock', 10000, '0.5', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (4, '50K Xu', 'coin', 50000, '0.2', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (5, '50K Xu khóa', 'coin_lock', 50000, '0.2', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (6, '500K Xu', 'coin', 500000, '0.001', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (7, '500K Xu khóa', 'coin_lock', 500000, '0.001', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (8, '1 Kim cương', 'diamond', 1, '0.01', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (9, '500 Kim cương', 'diamond', 500, '0.001', 1, 0, null);
INSERT INTO `ny_wheel_gift` VALUES (10, 'Thêm lượt', 'wheel', 1, '0.3', 1, 0, null);

DROP TABLE IF EXISTS `ny_log_wheel`;
CREATE TABLE `ny_log_wheel` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`server_id` varchar(100) NOT NULL,
`gift_id` int(11) NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_dice`;
CREATE TABLE `ny_dice` (
`default_jar` double(50,0) unsigned NOT NULL DEFAULT 10000000,
`jar` double(50,0) unsigned NOT NULL DEFAULT 0,
`need_vip` int(11) NOT NULL DEFAULT 0,
`percent_jar_six` int(11) NOT NULL DEFAULT 0,
`percent_jar_other` int(11) NOT NULL DEFAULT 0
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ny_dice` VALUES (10000000, 0, 0, 0, 10);


DROP TABLE IF EXISTS `ny_log_dice`;
CREATE TABLE `ny_log_dice` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`money` double NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_log_admin`;
CREATE TABLE `ny_log_admin` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`type` varchar(100) NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_giftcode`;
CREATE TABLE `ny_giftcode` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`server_id` varchar(100) NOT NULL DEFAULT 'all',
`max` int(11) unsigned DEFAULT 0,
`count` int(11) unsigned DEFAULT 0,
`gifts` text,
`expires_time` int(11) unsigned DEFAULT 0,
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_log_giftcode`;
CREATE TABLE `ny_log_giftcode` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`server_id` varchar(100) NOT NULL,
`giftcode_id` int(11) NOT NULL,
`action` text,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ny_log_ip`;
CREATE TABLE `ny_log_ip` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip` varchar(100) NOT NULL,
`block` tinyint(3) unsigned DEFAULT 0 COMMENT '0: Unblock, 1: Block',
`connect` double(50,0) DEFAULT 0,
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Log Login */
DROP TABLE IF EXISTS `ny_log_login`;
CREATE TABLE `ny_log_login` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`ip` varchar(100) NOT NULL,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Server */
DROP TABLE IF EXISTS `ny_server`;
CREATE TABLE `ny_server` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`server_id` varchar(100) NOT NULL,
`server_name` varchar(100),
`db_name` varchar(100),
`update_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Log Login Server */
DROP TABLE IF EXISTS `ny_log_login_server`;
CREATE TABLE `ny_log_login_server` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`account` varchar(100) NOT NULL,
`server_id` varchar(100) NOT NULL,
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Server Rank Gift */
DROP TABLE IF EXISTS `ny_server_rank_gift`;
CREATE TABLE `ny_server_rank_gift` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`server_id` varchar(100) NOT NULL,
`type` varchar(100) NOT NULL,
`min` int(11) unsigned DEFAULT 0,
`max` int(11) unsigned DEFAULT 0,
`gifts` text,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Gift Box */
DROP TABLE IF EXISTS `ny_gift`;
CREATE TABLE `ny_gift` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`list` text,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* ADS */
DROP TABLE IF EXISTS `ny_ads`;
CREATE TABLE `ny_ads` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(100) NOT NULL,
`type` varchar(100) NOT NULL,
`display` tinyint(3) unsigned NOT NULL DEFAULT 1 COMMENT '0: Hide, 1: Show',
`create_time` int(11) unsigned,
PRIMARY KEY (`id`),
KEY `id` (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;



