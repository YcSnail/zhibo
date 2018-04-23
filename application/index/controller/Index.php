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

//        $url = 'http://www.huya.com/longdd';
//        $url = 'https://www.panda.tv/99999';

//        $url = 'http://www.huomao.com/888';
        $url = 'https://www.huomao.com/666666';

        $Curl = model('curl');
        $res = $Curl->get($url);

        // 判断是否存在
        // host-prevStartTime

        // 检查是否 未直播
        dump($res);
        die();

        $checkStatus = strpos($res,"host-prevStartTime");
        // 如果 返回 数字 为 不在播  false 正在直播

        if ($checkStatus){
            return true;
        }
        return false;
    }


    // 判断虎牙 是否直播
    public function huya($url){

        if (empty($url)){
            return false;
        }

        $Curl = model('curl');
        $res = $Curl->get($url);

        // 判断是否存在
        // host-prevStartTime
        // 检查是否 未直播
        $checkStatus = strpos($res,"host-prevStartTime");

        // 如果 返回 数字 为 不在播  false 正在直播
        if ($checkStatus){
            return true;
        }
        return false;
    }


    public function douyu($url){

        if (empty($url)){
            return false;
        }

        $Curl = model('curl');
        $res = $Curl->get($url);

        // 判断是否存在
        // host-prevStartTime
        // 检查是否 未直播
        $checkStatus = strpos($res,'data-anchor-info="timetit"');

        // 如果 返回 数字 为 不在播  false 正在直播
        if ($checkStatus){
            return true;
        }
        return false;
    }

    public function panda(){

    }

    public function huomao(){

    }

    public function add(){
        // 添加 主播用户
        return $this->fetch();
    }

}
