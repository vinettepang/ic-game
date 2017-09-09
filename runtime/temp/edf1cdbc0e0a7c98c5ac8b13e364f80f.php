<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\micebear\public/../application/index\view\wechatquizzes\share.html";i:1493882026;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0" />
    <meta name="keywords" content="白熊求职 网申 PM 测试">
    <meta name="description" content="白熊求职 网申 PM 测试">
    <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/static/css/jquery.fancybox.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/wechatquizzes.css" />
    <title>白熊产品经理职业测试</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#482929">
    <meta name="theme-color" content="#ffffff">
    <script type="text/javascript" src="/static/js/jquery.1.10.1.min.js"></script>
    <script type="text/javascript" src="/static/js/wechatquizzes.js"></script>
    <script type="text/javascript" src=" http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script type="text/javascript" src="/static/js/jquery.fancybox.pack.js"></script>

</head>
<body>
<div class="wrap share-container">
 <!--    <div class="">
        <img id="headimgurl" src="" alt="图片">
        <p>你的好友【<span id="nickname"></span>】正在参加白熊求职PM测试，据说产品修为突飞猛进，还获得称号：<br />【<span id="keyword"></span>】</p>
        <p>据说闯过了可以免费拿到一份价值299的产品课程哟</p>
        <div class="over_btn_detail back"><a href="http://icebear.me/wechatquizzes/index">我也要玩</a></div>
    </div> -->

    <div class="share_wrap">
        <!-- <div class="share_text">
            <p class="full">分享到【朋友圈】晒成绩，同时还能查看每道题的解析哟~</p>
            <p class="fail">分享到【朋友圈】查看领取方法</p>
            <img class="share_img" src="/static/images/wechatquizzes/share.png">
        </div> -->
        <div class="share-img"></div>
        <div class="bg-bottom-right"></div>
    </div>

    <div class="share_success">
        <div class="share_success_img"><img src="/static/images/wechatquizzes/wechat_code.png"></div>
        <a class="btn btn-active" href="/wechatquizzes">再玩一次</a>
        <div class="bg-bottom-right"></div>
        <!-- <h1>关注公众号【白熊求职】并回复“PM秘籍”即可</h1>
        <img src="" alt="白熊小助手">
        <span>（长按识别二维码即可关注公众号）</span>
        <img src="" alt="">
        <div class="share_success_btn">返回成绩单</div>  -->

    </div>

</div><!-- /.wrap -->
<script type="text/javascript">
    function getUrlParam(name) {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
        var r = decodeURI(window.location.search).substr(1).match(reg);  //匹配目标参数
        if (r!=null) return unescape(r[2]); return null; //返回参数值
    }

    $(document).ready(function(){
        nickname = getUrlParam('nickname');
        keyword = getUrlParam('keyword');
        headimgurl = getUrlParam('headimgurl');
        $('#nickname').html(nickname);
        $('#keyword').html(keyword);
        $('#headimgurl').attr('src',headimgurl);
        console.log(nickname,keyword);
        var share = getUrlParam('share');
        var score = getUrlParam('score');
        var topic_length = getUrlParam('topic_length');

        if (share==1) {
            $('.share_wrap').css('display', 'block');
            //$('.share_success').css('display', 'block');
            // if (score == topic_length) {
            //     $('.share_text .full').css('display', 'block');
            // }
            // else{
            //     $('.share_text .fail').css('display', 'block');
            // }
        }
    });

     wx.config({
         debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
         appId: "<?php echo $wx_shareparm['appid'];?>", // 必填，公众号的唯一标识
         timestamp: "<?php echo $wx_shareparm['timestamp'];?>", // 必填，生成签名的时间戳
         nonceStr: "<?php echo $wx_shareparm['nonceStr'];?>", // 必填，生成签名的随机串
         signature: "<?php echo $wx_shareparm['signature'];?>",// 必填，签名，见附录1
         jsApiList: [
             'checkJsApi',
             'onMenuShareTimeline',
             'onMenuShareAppMessage'
         ]// 必填，需要使用的JS接口列表，所有JS接口列表见附录2
     });
     wx.ready(function () {
         //分享到朋友圈
         wx.onMenuShareTimeline({
             title: "我在参加「产品经理职业测试」，你也来试试吧！", // 分享标题
             link: "http://h5.icebear.me/wechatquizzes/index", // 分享链接
             imgUrl: "http://h5.icebear.me/static/images/wechatquizzes/test.png", // 分享图标
             success: function () {
                 $('.share_success').css('display', 'block');
                 $('.share_wrap').css('display', 'none');

             },
             cancel: function () {
                 $('.share_success').css('display', 'none');
                 $('.share_wrap').css('display', 'block');
             }
         });
         //分享给朋友
         wx.onMenuShareAppMessage({
             title: "产品经理职业测试",
             desc: "我在参加「产品经理职业测试」，你也来试试吧！",
             link: "http://h5.icebear.me/wechatquizzes/index",
             imgUrl: "http://h5.icebear.me/static/images/wechatquizzes/test.png",
             type: "link", // 分享类型：music、video、link，不填默认为link
             dataUrl: "", // 如果分享类型是music、video，则需要提供数据连接，默认为空
             success: function () {
                 $('.share_success').css('display', 'block');
                 $('.share_wrap').css('display', 'none');
             },
             cancel: function () {
                 $('.share_success').css('display', 'none');
                 $('.share_wrap').css('display', 'block');
             }
         });

     });

     wx.error(function (res) {
         alert(res.errMsg);
     });

/*          $('#btn-copy').click(function(){
              var sharecode=$("span#share-code").html();
              sharecode.select(); // 选择对象
              document.execCommand("Copy"); // 执行浏览器复制命令
              alert("已复制好，可贴粘。");
             var Url2=document.getElementById("share-code");
             Url2.select(); // 选择对象
             document.execCommand("Copy"); // 执行浏览器复制命令
             alert("已复制好，可贴粘。");
         });
         function copyText(){
             var Url2=document.getElementById("share-code");
             Url2.select(); // 选择对象
             document.execCommand("Copy"); // 执行浏览器复制命令
             alert("将提取码粘贴至公众号对话框,即可获得礼包链接!");
         }
          $(document).ready(function(){
         var fooText=$("#foo").text();
         var clipboard = new Clipboard('#copy_btn');

         clipboard.on('success', function(e) {
             console.info('Action:', e.action);
             console.info('Text:', e.text);
             console.info('Trigger:', e.trigger);
             alert("复制成功");

             e.clearSelection();
         });
     }); */

</script>
<script src="/static/js/analytics.js"></script>
</body>
</html>