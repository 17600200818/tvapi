<?php
namespace Home\Controller;

class MenuController extends BaseController {
    public function createMenu()
    {
//        $menu = array(
//            'button' => array(
//                array(
//                    'type' => 'click',
//                    'name' => '中文标题',
//                    'key' => 'is_key'
//                ),
//                array(
//                    'name' => '菜单',
//                    'sub_button' => array(
//                        array(
//                            'type' => 'view',
//                            'name' => '搜索',
//                            'url' => 'http://119.27.184.82/shop'
//                        )
//                    )
//                )
//            )
//        );
        $menu = array(
            'button' => array(
                array(
                    'name' => '扫码',
                    'sub_button' => array(
                        array(
                            'type' => 'scancode_waitmsg',
                            'name' => '扫码带提示',
                            'key' => 'rselfmenu_0_0',
                            'sub_button' => array(),
                        ),
                        array(
                            'type' => 'scancode_push',
                            'name' => '扫码推事件',
                            'key' => 'rselfmenu_0_1',
                            'sub_button' => array(),
                        ),
                    )
                ),
                array(
                    'name' => '发图',
                    'sub_button' => array(
                        array(
                            'type' => 'pic_sysphoto',
                            'name' => '系统拍照发图',
                            'key' => 'rselfmenu_1_0',
                            'sub_button' => array(),
                        ),
                        array(
                            'type' => 'pic_photo_or_album',
                            'name' => '拍照或者相册发图',
                            'key' => 'rselfmenu_1_1',
                            'sub_button' => array(),
                        ),
                        array(
                            'type' => 'pic_weixin',
                            'name' => '微信相册发图',
                            'key' => 'rselfmenu_1_2',
                            'sub_button' => array(),
                        ),
                    ),
                ),
                array(
                    'name' => '其他',
                    'sub_button' => array(
                        array(
                            'type' => 'location_select',
                            'name' => '发送位置',
                            'key' => 'rselfmenu_2_0',
                        ),
                        array(
                            'type' => 'click',
                            'name' => '中文标题',
                            'key' => 'is_key'
                        ),
                        array(
                            'type' => 'view',
                            'name' => '搜索',
                            'url' => 'http://119.27.184.82/user/getcode'
                        )
//                        array(
//                            'type' => 'media_id',
//                            'name' => '图片',
//                            'media_id' => 'MEDIA_ID1',
//                        ),
//                        array(
//                            'type' => 'view_limited',
//                            'name' => '图文消息',
//                            'media_id' => 'MEDIA_ID2',
//                        ),
                    ),
                )
            )
        );

        $menu = json_encode($menu, JSON_UNESCAPED_UNICODE);

        $response = $this->curlPost("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$this->accessToken", $menu);
        $this->echoPre($response);
    }

    public function getMenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$this->accessToken";
        $response = $this->curlGet($url);
        $this->echoPre($response);
    }

    public function delMenu()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=$this->accessToken";
        $response = $this->curlGet($url);
        $this->echoPre($response);
    }
}