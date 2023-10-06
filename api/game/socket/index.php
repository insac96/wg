<?php
require 'core/WebsocketClient.php';
require 'core/WebSocketParser.php';
require 'core/Parser.php';
ini_set('display_errors', 'Off');
error_reporting(0);

function sendSocket($host, $port, $params)
{
    $Client = new \Swoole\Client\WebsocketClient($host, $port);
    $Client->connect();
    $send_buff = $Client->publish($params['opcode'], $params['str']);
    $Client->send($send_buff, 'bin');
    $returnData = $Client->recv();
    $res = $Client->unPublish($returnData);
    $return = empty($res) ? 2 : 1;
    return $return;
}


