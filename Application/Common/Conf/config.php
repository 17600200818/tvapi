<?php
return array(
    'URL_MODEL' => 2,
//    'URL_CASE_INSENSITIVE'  =>  true, //url不区分大小写
//    'debug' => true,

    'Token' => 'youngty',
    'AppID' => 'wxdc39b4fbfbbf9987',
    'appsecret' => 'd4624c36b6795d1d99dcf0547af5443d',

    'REDIS_RW_SEPARATE' => true, //Redis读写分离 true 开启
    'REDIS_HOST'=>'127.0.0.1', //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
    'REDIS_PORT'=>'6379',//端口号
    'REDIS_TIMEOUT'=>'300',//超时时间
    'REDIS_PERSISTENT'=>true,//是否长连接 false=短连接
);
