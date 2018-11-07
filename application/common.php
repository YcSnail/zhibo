<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * ajax 返回数据
 * @param $code
 * @param string $msg
 */
function ajaxRes($code, $msg = '保存成功'){
    $arr = array(
        'code' => $code,
        'message' => $msg
    );
    die(json_encode($arr));
}

// 处理 base64文件
function base64SaveFile($base64Arr,$isOneArr = false){
    if (empty($base64Arr)){
        return '';
    }
    $imgFileStr = '';

    if (!is_array($base64Arr)){
        return '';
    }
    $imgNameArr = [];
    for ($i=0;$i<count($base64Arr);$i++){

        if ($isOneArr){
            $imgNameArr[] = setBase64File($base64Arr[$i]);
        }else{
            for ($l=0;$l<count($base64Arr[$i]);$l++){
                $imgNameArr[] = setBase64File($base64Arr[$i][$l]);
            }
        }

    }

    // 把数组处理成 字符串,方便存储
    if (!empty($imgNameArr)){
        $imgFileStr = implode(',',$imgNameArr);
    }

    return $imgFileStr;
}

// 把 base64 保存为文件, 并返回 文件名称
function setBase64File($base64Code){
    if (empty($base64Code)){
        return false;
    }

    // 处理文件
    // 删除 url(" "),取出中间的值
//    $base64Code = substr($base64Code, 5, -2);

    $base64Arr = explode(',',$base64Code);
    $imgType = explode('/',explode(';',$base64Arr[0])[0])[1];
    $imgDataBase64 = $base64Arr[1];

    // 获取当前时间
    $time = date('Ymd');
    // 判断文件夹 存不存在
    $dir = 'uploadImgFile';
    $fileName = $dir;
    if (!is_dir($fileName)) {
        @mkdir($fileName);
        chmod($fileName,0777);
    }
    $fileName = $dir.'/'.$time;
    if (!is_dir($fileName)) {
        @mkdir($fileName);
        chmod($fileName,0777);
    }

    $imgData = base64_decode($imgDataBase64);
    $fileName = $fileName.'/'.time();
    $imgName = $fileName.'.'.$imgType;

    // 判断文件是否存在
    if (file_exists($imgName)){
        $randNum = rand(0,99);
        $imgName = $fileName . $randNum.'.'.$imgType;
    }

    $putStatus = file_put_contents($imgName, $imgData);//返回的是字节数
    if ($putStatus){
        return '/'.$imgName;
    }
    return false;
}

function checkStatus($userRes){

    if (empty($userRes)){
        return false;
    }

    // 循环 检测主播状态
    for ($i=0;$i<count($userRes);$i++){

        $userRes[$i]['status']  = false;

        if (empty($userRes[$i]['url'])){
            return false;
        }

        if ( strstr($userRes[$i]['url'] , 'huya' ) ){
            $userRes[$i]['status']  = huya($userRes[$i]['url']);
        }

        if ( strstr($userRes[$i]['url'] , 'douyu' ) ){
            $userRes[$i]['status']  = douyu($userRes[$i]['url']);
        }

        if ( strstr($userRes[$i]['url'] , 'huomao' ) ){
            $userRes[$i]['status']  = huomao($userRes[$i]['url']);
        }

        if ( strstr($userRes[$i]['url'] , 'panda' ) ){
            $userRes[$i]['status']  = panda($userRes[$i]['url']);
        }

    }

    return $userRes;
}



// 判断虎牙 是否直播
/**
 * @param $url
 * @return bool
 * true 正在直播
 * false 未在直播
 */
function huya($url){

    if (empty($url)){
        return false;
    }

    $Curl = model('curl');
    $res = $Curl->get($url);

    // 判断是否存在
    // host-prevStartTime
    // 检查是否 未直播
    $checkStatus = strpos($res,"host-prevStartTime");
    unset($res);
    // 如果 返回 数字 为 不在播  false 正在直播
    if ($checkStatus){
        return false;
    }
    return true;
}


function douyu($url){

    if (empty($url)){
        return false;
    }

    $Curl = model('curl');
    // 处理链接为移动端
    $url = str_replace("www","m",$url);
    $res = $Curl->get($url,'',true);

    // 判断是否存在
    // host-prevStartTime
    // 检查是否 未直播
    $checkStatus = strpos($res,'"isLive":0,');

    unset($res);
    // 如果 返回 数字 为 不在播  false 正在直播
    if ($checkStatus){
        return false;
    }
    return true;
}


function huomao($url){

    $Curl = model('curl');
    $res = $Curl->get($url);

    $checkStatus = strpos($res,'var is_videoicon = 1;');

    if ($checkStatus){
        return false;
    }
    return true;
}

function panda($url){

    if (empty($url)){
        return false;
    }

    $Curl = model('curl');
    $res = $Curl->get($url);

    // 判断是否存在
    // 检查是否 未直播
    $checkStatus = strpos($res,'"watermark_switch":"1",');

    unset($res);
    // 如果 返回 数字 为 不在播  false 正在直播
    if ($checkStatus){
        return false;
    }
    return true;
}
