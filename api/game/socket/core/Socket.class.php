<?php
/**
 * Created by PhpStorm.
 * User: w
 * Date: 2018/10/29
 * Time: 17:33
 */
class Socket
{
    public $server;
    private $handler = array(
        'start' => 'onStart',
        'workerStart' => 'onWorkerStart',
        'message' => 'onMessage',
        // 'workerExit' =>'onWorkerExit',
        // 'workerStop' => 'onWorkerStop',
        'close' => 'onClose',
    );

    public function __construct()
    {
        if (!class_exists('swoole_websocket_server')) {
            throw new Exception ('Swoole扩展未安装或服务未启动');
        }

        $_this = $this;
        $server = new swoole_websocket_server(SOCKET_SERVER_IP, SOCKET_SERVER_PORT, SWOOLE_BASE, SOCKET_SERVER_SSL ? SWOOLE_SOCK_TCP | SWOOLE_SSL : SWOOLE_SOCK_TCP);
        $config = array('worker_num' => SOCKET_SERVER_WORKNUM, 'daemonize' => 1, 'log_file' => __DIR__ . '/swoole.log');

        if (SOCKET_SERVER_DEBUG) {
            unset($config['daemonize']);
        }

        if (SOCKET_SERVER_SSL) {
            $config['ssl_key_file'] = SOCKET_SERVER_SSL_KEY_FILE;
            $config['ssl_cert_file'] = SOCKET_SERVER_SSL_CERT_FILE;
        }

        $server->set($config);


//        $server->on('Message', function(swoole_websocket_server $server, $frame) use(&$_this) {
//            $data = json_decode($frame->data, true);
//            $data = $_this->special($data);
//            $_this->log('msg_server', json_encode($frame));
//
//        });

        foreach ($this->handler as $k => $v) {
            if (method_exists($this, $v)) {
                $this->server->on($k, array($this, $v));
            }
        }

        $this->server = $server;
        $this->server->start();
    }


    public function onStart()
    {
        //设置进程名
        swoole_set_process_name('PHP CENTER_ADMIN SOCKET MASTER');
    }



    public function onMessage(swoole_websocket_server  $server, swoole_websocket_frame $frame)
    {
        if (!empty($frame->data)) {
            //当客户端的消息不为空时

            $msg = $frame->fd."123\n";

            foreach($GLOBALS['fd'] as $aa){
                foreach($aa as $i){
                    $this->server->push($i,$msg);
                }
            }

        } else {
            $this->log('socket_msg', json_encode($frame));
        }
    }

    public function log($name, $text)
    {
        $filename = dirname(__FILE__) . '/log_' . $name . '.log';
        $text = '[' . date('Y-m-d H:i:s', time()) . '] ' . $text;
        file_put_contents($filename, $text . "\r\n", FILE_APPEND);
    }

}
error_reporting(SOCKET_SERVER_DEBUG ? 32767 : 0);
ini_set('default_socket_timeout', -1);
$server = new Socket();
