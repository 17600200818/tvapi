<?php
namespace Home\Controller;

class IndexController extends BaseController {
    public function index(){
        //设置url接入代码
        if (I('echostr')) {
            echo I('echostr');
            exit();
        }

        //接收微信推送消息
        $xmldata=file_get_contents("php://input");
        $data=simplexml_load_string($xmldata, 'SimpleXMLElement', LIBXML_NOCDATA);

        //处理微信消息
        $this->handleWechatMsg($data);

        //记录日志
        $data = json_encode($data);
        error_log(date("Y-m-d H:i:s")." ".$data."\n",3,APP_PATH."./Runtime/Logs/Home/".date("Ymd").".log");
    }

    //处理微信消息
    public function handleWechatMsg($data)
    {
        switch ($data->MsgType) {
            case 'text':
                $this->returnMsgToUser($data, $data->Content);
                break;
            case 'event':
                switch ($data->Event) {
                    //返回xml参数
                    case 'CLICK':

                        break;

                    case 'subscribe':
                        $this->returnMsgToUser($data, '来啦');
                        break;

                    case 'unsubscribe':
                        $this->returnMsgToUser($data, '滚吧');
                        break;
                }


                break;
        }

        if ($data->MsgType = 'event') {

        }


//        //返回xml参数
//        $xml =  "<xml> <ToUserName><![CDATA[$data->FromUserName]]></ToUserName> <FromUserName><![CDATA[$data->ToUserName]]></FromUserName> <CreateTime>".time()."</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[你好]]></Content> </xml>";
//        echo $xml;
    }

    public function returnMsgToUser($data, $msg)
    {
        $xml =  "<xml> <ToUserName><![CDATA[$data->FromUserName]]></ToUserName> <FromUserName><![CDATA[$data->ToUserName]]></FromUserName> <CreateTime>".time()."</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[$msg]]></Content> </xml>";

        echo $xml;
    }

}