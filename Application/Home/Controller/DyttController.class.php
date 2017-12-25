<?php
namespace Home\Controller;
use Think\Controller;

class DyttController extends Controller {
    public function add()
    {
        $list = I('list');
        $listStr = substr($list, 2, -2);
        $listArr = explode("', '", $listStr);
        $data = array();
        foreach ($listArr as $value) {
            if ($value) {
                $data[] = array('url' => $value);
            }
        }
        $result = D('Dytts')->addAll($data);

        if ($result) {
            echo 'ok';
        }else {
            echo 'error';
        }
    }
}