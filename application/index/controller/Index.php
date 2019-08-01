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

        $url = 'https://www.panda.tv/99999';
        $url = 'https://www.panda.tv/2009';

        $Curl = model('curl');
        $res = $Curl->get($url);

        // 检查是否 未直播

    }

    public function panda(){

    }

    public function ti9(){

        return $this->fetch();
    }


    public function add(){
        // 添加 主播用户
        return $this->fetch();
    }

}
