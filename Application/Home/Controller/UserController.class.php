<?php
namespace Home\Controller;

class UserController extends BaseController {
    public function getCode()
    {
        $this->getJweixinConfig();
        $this->display();
    }
}