<?php

namespace app\index\controller;
use think\Controller;
use think\Db;
class Home extends Controller{
    public $wx_shareparm = [];
    public function __construct(){
        parent::__construct();
        error_reporting(E_ALL & ~E_NOTICE);
        $this->wx_config = getWxconfig();
        $this->wx_shareparm = getWxshareparm();
        $this->view->wx_shareparm = $this->wx_shareparm;
    }
}