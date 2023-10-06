<?php
include_once('../api/config.php');
require_once API_DIR.'/includes/utils.php';
require_once API_DIR.'/includes/pdo.php';
require_once API_DIR.'/service/configAction/index.php';
$config = (new Config())->getConfig();
?>

<!doctype html>
<html lang="vi">
<head>
  <title><?php echo $config['game_name']; ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
  <meta name="description" content="<?php echo $config['game_info']; ?>">
  <meta property="og:title" content="<?php echo $config['game_name']; ?>" />
  <meta property="og:description" content="<?php echo $config['game_info']; ?>">
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?php echo $config['web_link']; ?>" />
  <meta property="og:image" content="<?php echo $config['game_banner']; ?>" />
  <meta property="og:locale" content="VI_VN" />
  <meta property="og:locale:alternate" content="en_US" />
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Quicksand:300,400,500,600,700">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <script src="/client/js/devtool.js"></script>
  
  <!--Change for Production-->
  <script defer="defer" src="/client/js/chunk-vendors.5b7d5129.js"></script>
  <script defer="defer" src="/client/js/app.0e3c03b5.js"></script>
  <link href="/client/css/app.f4f79f7a.css" rel="stylesheet">
</head>

<body>
  <script type="text/javascript">
    window.CONFIG = <?php echo json_encode($config); ?>;
    window.SOCKET_URL = "<?php echo SOCKET_URL; ?>";
  </script>
  <div id="app"></div>
</body>
</html>