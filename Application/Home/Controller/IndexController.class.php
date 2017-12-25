<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        echo 'aaa';

        //记录日志
//        $data = json_encode($data);
//        error_log(date("Y-m-d H:i:s")." ".$data."\n",3,APP_PATH."./Runtime/Logs/Home/".date("Ymd").".log");
    }
}
