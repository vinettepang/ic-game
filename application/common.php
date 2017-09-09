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
use think\Db;
use think\Route;
// 应用公共文件
Route::bind('index');
function getWxconfig($wx = 'awxu'){
    $arr = ['awxu'=>[
            'appid' => 'wx5d8261bc6a1a6750',
            'apps' => '95383f3797be615ee4df8da52b402e43',
            'yid'   => 'gh_d112fbff3a6e',
            'token' => '4Yr8TVM3DYVvrqxG',
            'aeskey' => 'J9X2hqSH2wpcFZ8a3USZa1O9yfikcSXdzmVHdRIkTzX',
            'name'  => '课程服务号',
            ],
        ];
    return $arr[$wx];
}

/**
 * 获取签名
 * @return 包括签名的数组
 */
function getWxshareparm(){
    $account = getWxConfig();
    $appid  = $account['appid'];
    $appsecret = $account['apps'];
    $access_token = cookie('token');
    if(!$access_token){
        $access_token = get_token($appid,$appsecret);
    }
    $timestamp = time();
    $jsapi_ticket = cookie('jsapi_ticket');
    if(!$jsapi_ticket){
        $jsapi_ticket = make_ticket($access_token);
        if(!$jsapi_ticket){//ticket没有值说明access_token失效，需重新获取access_token
            cookie('token',null);
            $access_token = get_token($appid,$appsecret);
            $jsapi_ticket = make_ticket($access_token);
        }
    }
    $nonceStr = make_nonceStr();
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $signature = make_signature($nonceStr,$timestamp,$jsapi_ticket,$url);
    $data = array(
        'appid' => $appid,
        'timestamp' => $timestamp,
        'nonceStr' => $nonceStr,
        'signature' => $signature,
    );
    return $data;
}

/**
 * 
 * @param $appid
 * @param $appsecret
 * @return $access_token
 */
function get_token($appid,$appsecret){
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $jsoninfo = json_decode($output, true);
    $access_token = $jsoninfo["access_token"];
    cookie('token',$access_token,7000);
    return $access_token;
}

/**
 * 
 * @param $access_token
 * @return ticket
 */
function make_ticket($access_token)
{
    $ticket_URL = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
    $json = file_get_contents($ticket_URL);
    $result = json_decode($json,true);
    $ticket = $result['ticket'];
    cookie('jsapi_ticket',$ticket,7000);
    return $ticket;
}

/**
 * 
 */
function make_nonceStr(){
    $codeSet = 'E4xcqyCe8IEuTYT6lQ4k6kmhkDUztfezSN6IeaqmdHYMMMQfbGI3pIomkSFFHs';
    for ($i = 0; $i<16; $i++) {
        $codes[$i] = $codeSet[mt_rand(0, strlen($codeSet)-1)];
    }
    $nonceStr = implode($codes);
    return $nonceStr;
}

/**
 * 
 * @param $nonceStr
 * @param $timestamp
 * @param $jsapi_ticket
 * @param $url
 */
function make_signature($nonceStr,$timestamp,$jsapi_ticket,$url){
    $tmpArr = array(
        'noncestr' => $nonceStr,
        'timestamp' => $timestamp,
        'jsapi_ticket' => $jsapi_ticket,
        'url' => $url,
    );
    ksort($tmpArr, SORT_STRING);
    $string1 = http_build_query( $tmpArr );
    $string1 = urldecode( $string1 );
    $signature = sha1( $string1 );
    return $signature;
}

/**
 * 
 * @param $msg
 * @param string $type
 */
function customError($msg,$type="error"){
	print_test($msg);
	exit();
}

/**
 * 
 * @param  $arr
 * @param  $exit
 */
function print_test($arr,$exit=1){
	echo '<pre>';
	print_r($arr);
	if($exit){
		exit;
	}
}

/**
 * 
 * @param  $user
 * @param  $token
 * @param  $status
 */
function addFollow($user,$token='',$status=1){
	$data = array(
			'token'=>$token,
			'openid'=>$user['openid'],
			'nickname'=>$user['nickname'],
			'sex'=>$user['sex'],
			'city'=>$user['city'],
			'province'=>$user['province'],
			'country'=>$user['country'],
			'language'=>$user['language'],
			'headimgurl'=>$user['headimgurl'],
			'subscribe_time'=>date("Y-m-d H:i:s",$user['subscribe_time']),
			'addtime'=>date("Y-m-d H:i:s"),
			'unionid'=>$user['unionid'],
			'status'=>$status,
	);
	Db::name('wx_follow')->insert($data);
}

//添加微信日志
function addWxLog($yid,$post='',$reply='',$ext=array()){
    if(!$ext){
        $ext = $post;
    }
    $data = array(
        'yid'=>$yid,
        'post'=>is_array($post)?serialize($post):$post,
        'reply'=>is_array($reply)?serialize($reply):$reply,
        'type'=>$ext['MsgType'],
        'event'=>$ext['Event'],
        'eventkey'=>$ext['eventkey'],
        'openid'=>$ext['FromUserName'],
        'keyword'=>$ext['Content'],
        'add_time'=>date("Y-m-d H:i:s"),
    );
    Db::name('wx_log')->insert($data);
}
//添加获微信日志

function addWxaccessLog($appid,$access_token,$action = 'get_token'){
	$data = [
			'appid'=>$appid,
			'access_token'=>$access_token,
			'action'=>$action,
			'get_time'=>date("Y-m-d H:i:s"),
	];
	Db::name('wx_token')->insert($data);
}