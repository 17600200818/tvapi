<?php

namespace Home\Controller;
//use Think\Cache\Driver\Redis;
use Think\Controller;

class BaseController extends Controller
{
    public $appId;
    public $appSecret;
    public $accessToken;

    public function __construct()
    {
        parent::__construct();

        $this->appId = C('AppID');
        $this->appSecret = C('appsecret');
        $this->accessToken = $this->getAccessToken();
        $this->jsapiTicket = $this->getJsapiTickt();
    }

    public function curlGet($url)
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        return json_decode($output, true);
    }

    public function curlPost($url, $post_data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);

        //打印获得的数据
        return json_decode($output, true);
    }

    public function getCallBackIp()
    {
        $accessToken = $this->getAccessToken();
        $response = $this->curlGet("https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$accessToken");

        return $response['ip_list'];
    }

    public function echoPre($arr)
    {
        echo "<pre>";
        print_r($arr);
    }

    public function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key=>$val){
            if(is_array($val)){
                $xml.="<".$key.">".arrayToXml($val)."</".$key.">";
            }else{
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    function randomStr( $length = 8 ) {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $noUsedStr = '!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
        $password = '';
        for ( $i = 0; $i < $length; $i++ )
        {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        return $password;
    }

    public function getAccessToken()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $accessToken = $redis->get('access_token');
        return $accessToken;
    }

    public function getJsapiTickt()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $jsapiTicket = $redis->get('jsapi_ticket');
        return $jsapiTicket;
    }

    public function getSignature($url)
    {
        $signArr = array(
            'noncestr' => $this->randomStr(),
            'jsapi_ticket' => $this->jsapiTicket,
            'timestamp' => time(),
            'url' => $url
        );
        ksort($signArr);

        $signStr = '';
        $i = '';
        foreach ($signArr as $key => $value) {
            $signStr .= $i.$key.'='.$value;
            $i = '&';
        }

        $signArr['signStr'] = $signStr;
        $signArr['signature_bak'] = sha1($signStr);
        $signArr['signature'] = sha1("jsapi_ticket=".$signArr['jsapi_ticket']."&noncestr=".$signArr['noncestr']."&timestamp=".$signArr['timestamp']."&url=$url");

        return $signArr;
    }

    public function getJweixinConfig()
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
        $urlArr = explode('#', $url);
        $signArr = $this->getSignature($urlArr[0]);
//        $this->echoPre($signArr);

        $this->assign('signArr', $signArr);
        $this->assign('appid', $this->appId);
    }
}
