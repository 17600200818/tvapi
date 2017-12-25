<?php
namespace Home\Controller;

class MsgController extends BaseController {
    public function sendText()
    {
        $data = array(
            'filter' => array(
                'is_to_all' => true,
//                'tag_id' => 2
            ),
            'text' => array(
                'content' => '嘎哈'
            ),
            'msgtype' => 'text'
        );

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=$this->accessToken";

        $response = $this->curlPost($url, $data);
        $this->echoPre($response);
    }

    public function delSendedMsg()
    {
        Header('Location: https://mp.weixin.qq.com/mp/subscribemsgaction=get_confirm&appid='.$this->appId.'&scene=1000&template_id=&redirect_url=http://119.27.184.82');
    }

    public function setIndustry()
    {
        $data = array('industry_id1' => '1', 'industry_id2' => 4);
        $data = json_encode($data);
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=$this->accessToken";

        $response = $this->curlPost($url, $data);
        $this->echoPre($response);
    }

    public function getAllTemplete()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=$this->accessToken";

        $response = $this->curlGet($url);
        $this->echoPre($response);
    }
}