<?php
namespace app\index\controller;
use think\Db;
use wechat\Wechat;
use wechat\WechatAuth;
class Wx extends Home{
    public function __construct(){
        parent::__construct();
        header('Content-Type:text/html;charset=utf-8');
    }
    public function index(){
        try{
            $appid = $this->wx_config['appid'];
            $token = $this->wx_config['token'];
            $crypt = $this->wx_config['aeskey'];
            $wechat = new Wechat($token, $appid, $crypt);
            $data = $wechat->request();
            //记录微信推送过来的数据
            addWxLog($this->wx_config['yid'], $data, trim($data['Content']));
            if ($data && is_array($data)) {
                /**
                 * 你可以在这里分析数据，决定要返回给用户什么样的信息
                 * 接受到的信息类型有10种，分别使用下面10个常量标识
                 * Wechat::MSG_TYPE_TEXT       //文本消息
                 * Wechat::MSG_TYPE_IMAGE      //图片消息
                 * Wechat::MSG_TYPE_VOICE      //音频消息
                 * Wechat::MSG_TYPE_VIDEO      //视频消息
                 * Wechat::MSG_TYPE_SHORTVIDEO //视频消息
                 * Wechat::MSG_TYPE_MUSIC      //音乐消息
                 * Wechat::MSG_TYPE_NEWS       //图文消息（推送过来的应该不存在这种类型，但是可以给用户回复该类型消息）
                 * Wechat::MSG_TYPE_LOCATION   //位置消息
                 * Wechat::MSG_TYPE_LINK       //连接消息
                 * Wechat::MSG_TYPE_EVENT      //事件消息
                 *
                 * 事件消息又分为下面五种
                 * Wechat::MSG_EVENT_SUBSCRIBE    //订阅
                 * Wechat::MSG_EVENT_UNSUBSCRIBE  //取消订阅
                 * Wechat::MSG_EVENT_SCAN         //二维码扫描
                 * Wechat::MSG_EVENT_LOCATION     //报告位置
                 * Wechat::MSG_EVENT_CLICK        //菜单点击
                 */
            
                if ($data['MsgType'] == 'event' && $data['Event']) {
                    switch ($data['Event']) {
                        case Wechat::MSG_EVENT_CLICK:
                            $keyword = trim($data['EventKey']);
                    }
                }
                /**
                 * 响应当前请求还有以下方法可以使用
                 * 具体参数格式说明请参考文档
                 *
                 * $wechat->replyText($text); //回复文本消息
                 * $wechat->replyImage($media_id); //回复图片消息
                 * $wechat->replyVoice($media_id); //回复音频消息
                 * $wechat->replyVideo($media_id, $title, $discription); //回复视频消息
                 * $wechat->replyMusic($title, $discription, $musicurl, $hqmusicurl, $thumb_media_id); //回复音乐消息
                 * $wechat->replyNews($news, $news1, $news2, $news3); //回复多条图文消息
                 * $wechat->replyNewsOnce($title, $discription, $url, $picurl); //回复单条图文消息
                 *
                 */
                //执行
                $this->reply($wechat, $data);
            }
        }catch (\Exception $e){
            addWxLog($this->wx_config['yid'], json_encode($e->getMessage()), '服务器繁忙，请稍后再试。', ['type' => 'error']);
            $wechat->replyText("服务器繁忙，请稍后再试。");
        }
    }
    
    /**
     * reply
     * @param  Object $wechat Wechat对象
     * @param  array $data 接受到微信推送的消息
     */
    private function reply($wechat, $data)
    {
        switch ($data['MsgType']) {
            case Wechat::MSG_TYPE_EVENT:
                switch ($data['Event']) {
                    case Wechat::MSG_EVENT_SUBSCRIBE:
                        $wechat_auth = new WechatAuth($this->wx_config['appid'], $this->wx_config['apps']);
                        $userinfo = $wechat_auth->getUserInfo_new($data['FromUserName']);
                        addFollow($userinfo, $this->wx_config['yid'], 1);
                        break;
                    case Wechat::MSG_EVENT_UNSUBSCRIBE:
                        //取消关注，解除绑定
                        //addWxLog($this->account['yid'],$data,'');
                        Db::name("wx_follow")->
                        where(['openid'=>$data['FromUserName'], 'token'=>$this->account['yid']])->
                        insert(['status' => -1]);
                        break;
                    default:
                        //$wechat->replyText("欢迎访问'.$this->account['appid'].'！您的事件类型：{$data['Event']}，EventKey：{$data['EventKey']}");
                        break;
                }
                break;
            case Wechat::MSG_TYPE_TEXT:
                $keyword = trim($data['Content']);
                $wechat_auth = new WechatAuth($this->wx_config['appid'],$this->wx_config['apps']);
                if($keyword){
                    if($keyword == 'ok'){
                    	$jsonuserinfo = json_encode($wechat_auth->getUserInfo_new($data['FromUserName']));
                    	$wechat->replyText($jsonuserinfo);
                        //$wechat->replyText('ok');
                    }else{
                        $wechat->replyText('welcome');
                    }
                }
                break;
            default:
                # code...
                break;
        }
        $openid = $data['FromUserName'];
        //暂时取消默认回复
        $wechat->replyText('公众号正在测试中,感谢您的关注'.$openid);
    }
}