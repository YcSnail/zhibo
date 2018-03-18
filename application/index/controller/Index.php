<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 获取视频
     */
    public function getVideo(){

        $url = 'http://www.huya.com/longdd';

        $Curl = model('curl');
        $res = $Curl->get($url);
    }


    public function add(){
        // 添加 主播用户
        return $this->fetch();
    }

}
