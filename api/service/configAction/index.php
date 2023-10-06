<?php
require 'utils.php';

class Config extends ConfigUtils {
  /* Get Config */
  public function getConfig () {
    $config = (new _PDO())->select(self::$PDO_GetConfig, []);
    unset($config['api_key_card']);
    unset($config['url_callback_card']);
    unset($config['api_key_momo']);
    unset($config['url_callback_momo']);
    unset($config['api_key_banking']);
    unset($config['url_callback_banking']);
    return $config;
  }

  /* Get Config All */
  public function getConfigAll () {
    $config = (new _PDO())->select(self::$PDO_GetConfig, []);
    return $config;
  }
}