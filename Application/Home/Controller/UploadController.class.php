<?php
namespace Home\Controller;

class UploadController extends BaseController {
    public function uploadImg()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=$this->accessToken";
//        $exec = "curl -F media=@test.jpg $url";
//        $log = shell_exec($exec);
//
////        $log = json_encode($log);
//        error_log(date("Y-m-d H:i:s")." ".$exec."\n",3,APP_PATH."./Runtime/Logs/Home/".date("Ymd").".log");
        $this->assign('url', $url);
        $this->display();
    }
}