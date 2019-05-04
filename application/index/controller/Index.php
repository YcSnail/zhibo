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
        dump($res);
        die();

    }

    public function test(){

        // post
        // http://www.huomao.com/swf/live_data

        //cdns:1
        //streamtype:live
        //VideoIDS:W4iEStLLyOmZMR5EPUuKXjx3kA
        //from:huomaoh5room
        //time:1542382709
        //token:30cbd1788e3f6d123f25f5ce5e05dfec


        $cdns=1;
        $streamtype='live';
        $videoIDS = 'W4iEStLLyOmZMR5EPUuKXjx3kA';
        $time = '1542442916';
        $from = 'huomaoh5room';
        $token = 'e437a84ef2fa78c053a61acc34d0378c';

        $str = 'cdns='.$cdns.'&streamtype='.$streamtype.'&videoIDS='.$videoIDS.'&form='.$from.'&time='.$time;

        $str= 'cdns=1&streamtype=live&VideoIDS=W4iEStLLyOmZMR5EPUuKXjx3kA&from=huomaoh5room&time=1542442916';

        $pdw = md5($str);

        echo '本地加密:'.$pdw;
        echo '<hr>';
        echo '原加密后:' .$token;

    }


    public function add(){
        // 添加 主播用户
        return $this->fetch();
    }

}
