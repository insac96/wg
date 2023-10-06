<?php
require 'utils.php';

class Config extends ConfigUtils {
  /* Get Config */
  public function getConfig () {
    $config = (new _PDO())->select(self::$PDO_GetConfig, []);
    return $config;
  }

  /* Save Config */
  public function saveConfig () {
    (new _PDO())->update('ny_config', $_POST['config'], array(1=>1));
  }
}