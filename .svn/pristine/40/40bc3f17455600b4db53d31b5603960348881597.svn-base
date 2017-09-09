<?php
namespace app\index\controller;

class Index extends Home{
    public function __construct(){
        parent::__construct();
    }
    public function index()
    {
        $data['Content'] = 'wxtest';
        addWxLog($this->wx_config['yid'], $data, trim($data['Content']));
    }
}
