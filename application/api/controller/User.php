<?php
// +----------------------------------------------------------------------
// |  [ you slogan ]
// +----------------------------------------------------------------------
// | Author: you name  and you E-mail
// +----------------------------------------------------------------------
// | Date: 2018/3/18 Time: 15:34
// +----------------------------------------------------------------------

namespace app\api\controller;

use think\Db;
use think\Controller;

class User extends Controller {


    /**
     * 获取全部主播
     */
    public function getUserList(){


        // 查询数据库
        $userRes = Db::table('zb_user')->field('img,status,title,url,user_name')->select();

        // 判断上次更新时间
        if (empty($userRes)){
            ajaxRes(-1,'数据不存在!');
        }

        if (!isset($userRes[0])){
            ajaxRes(-1,'数据不存在!');

        }

        // 保存到数据库
        if (!empty($userRes)){
            ajaxRes(0,$userRes);
        }
        ajaxRes(-1,'数据不存在!');
    }

    // 添加主播
    public function add(){

        $post = input('post.');
        if (!isset($post['user_name'])  || !isset($post['url']) || !isset($post['img']) ){
            ajaxRes(-1,'请求数据不能为空!');
        }


        // 查询数据是否已经存在
        $user_name = $post['user_name'];
        $userRes = Db::table('zb_user')->where('user_name',$user_name)->find();
        if (!empty($userRes)){
            ajaxRes(-1,'当前主播已经存在!');
        }

        // 获取提交的 图片信息
        $imgArr = array(
            $post['img']
        );

        $fileImg = base64SaveFile($imgArr,true);

        $saveData = array(
            'user_name'=>$post['user_name'],
            'url'=>$post['url'],
            'img'=>$fileImg,
            'title'=>$post['title']
        );

        $userRes = Db::table('zb_user')->insert($saveData);

        if (empty($userRes)){
            ajaxRes(-1,'添加失败!');
        }

        ajaxRes(-1,'添加成功!');
    }


    public function getStatus(){

        // 查询数据库
        $userRes = Db::table('zb_user')->field('img,status,title,url,user_name')->select();

        // 判断上次更新时间
        if (empty($userRes)){
            ajaxRes(-1,'数据不存在!');
        }

        if (!isset($userRes[0])){
            ajaxRes(-1,'数据不存在!');

        }
        $userRes = checkStatus($userRes);

        // 保存到数据库
        if (!empty($userRes)){
            ajaxRes(0,$userRes);
        }
        ajaxRes(-1,'数据不存在!');
    }

}