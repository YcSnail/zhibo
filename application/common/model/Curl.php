<?php

/**
 * curl 请求类
 */
namespace app\common\model;

class Curl{

    public function get($url,$params = '',$isMobile = false){
        $paramsStr = '';
        if (is_array($params)){
            $paramsStr = implode($params);
        }

        $header = [];
        if ($isMobile){
            $header = array(
                'user-agent:Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Mobile Safari/537.36'
            );
        }

        $ret = $this->http($url, $paramsStr , 'GET',false,$header);
        return $ret;
    }

    public function post($url, $params,$json =false){
        $ret = $this->http($url, $params, 'POST',$json);
        return $ret;
    }

    /**
     * 发送HTTP请求方法，目前只支持CURL发送请求
     * @param string $url  请求URL
     * @param array $params 请求参数
     * @param string $method 请求方法GET/POST
     * @return array $data  响应数据
     */
    protected function http($url, $params, $method = 'GET',$json = false, $header = array(), $multi = false) {
        $opts = array(CURLOPT_TIMEOUT => 30, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HTTPHEADER => $header);
        /* 根据请求类型设置特定参数 */
        switch(strtoupper($method)) {
            case 'GET' :
                $opts[CURLOPT_URL] = $url;
                if (!empty($params)){
                    $opts[CURLOPT_URL] = $url . '&' . http_build_query($params);
                }
                break;
            case 'POST' :
                if ($json){
                    $params = $params;
                }else{
                    $params = $multi ? $params : http_build_query($params);
                }

                //判断是否传输文件
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default :
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error)
            throw new Exception('请求发生错误：' . $error);
        return $data;
    }

}
