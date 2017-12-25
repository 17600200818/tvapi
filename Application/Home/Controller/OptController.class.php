<?php
namespace Home\Controller;

class OptController extends BaseController {
    public function getAccessToken()
    {
        $response = $this->curlGet("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret");
        $access_token = $response['access_token'];

        return $access_token;
    }

    public function getJsapiTicket()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$this->accessToken&type=jsapi";

        $response = $this->curlGet($url);
        $ticket = $response['ticket'];

        return $ticket;
    }

    public function setParam()
    {
        $access_token = $this->getAccessToken();
        $ticket = $this->getJsapiTicket();

        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->set('access_token', $access_token);
        $redis->set('jsapi_ticket', $ticket);

        echo "access_token : $access_token <br/>";
        echo "jsapi_ticket: $ticket";
    }

    public function phpinfo()
    {
        phpinfo();
    }

}