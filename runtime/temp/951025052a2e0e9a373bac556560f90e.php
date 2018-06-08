<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:71:"/home/www/kc/public/../application/index/view/public/dispatch_jump.html";i:1496714366;s:67:"/home/www/kc/public/../application/index/view/public/base_weui.html";i:1496714366;s:62:"/home/www/kc/public/../application/index/view/public/wxjs.html";i:1496714366;s:64:"/home/www/kc/public/../application/index/view/public/tongji.html";i:1496714366;}*/ ?>
<!DOCTYPE HTML>
<html>
 <head>

        <title>消息提示</title>
        <meta name="keyword" content="消息提示">
        <meta name="description" content="消息提示">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/static/weui/dist/style/weui.css"/>
    <link rel="stylesheet" href="/static/css/style.css"/>
    
<style>

</style>



 </head>
<body ontouchstart>




<div class="page__bd">

	<div class="weui-msg">
		 <?php switch ($code) {case 1:?>
				<div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
				<div class="weui-msg__text-area">
					<h2 class="weui-msg__title">操作成功</h2>
					<p class="weui-msg__desc"><?php echo(strip_tags($msg));?></p>
					<br/>
					<p class="weui-msg__desc" class="jump">
						页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
					</p>
				</div>
			 <?php break;case 0:?>
				<div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
				<div class="weui-msg__text-area">
					<h2 class="weui-msg__title">操作失败</h2>
					<p class="weui-msg__desc"><?php echo(strip_tags($msg));?></p>
					<br/>
					<p class="weui-msg__desc" class="jump">
						页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
					</p>
				</div>
			 <?php break;} ?>
		

		


		
		<div class="weui-msg__extra-area">
			<div class="weui-footer">
				<p class="weui-footer__text"><?php echo $settings['copyright']; ?></p>
			</div>
		</div>
	</div>



</div>



<script src="/static/js/jquery-1.8.2.min.js"></script>


<script type="text/javascript">
	(function(){
		var wait = document.getElementById('wait'),
			href = document.getElementById('href').href;
		var interval = setInterval(function(){
			var time = --wait.innerHTML;
			if(time <= 0) {
				location.href = href;
				clearInterval(interval);
			};
		}, 1000);
	})();
</script>




<?php if($is_mobile): ?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {

	

    $.getJSON('<?php echo \think\Url::build('api/sign');?>?url=' + encodeURIComponent(location.href.split('#')[0]), function (msg) {

		var res = msg.data;
		var _hideMenu = "<?php echo $wx_option['hideMenu']; ?>";
		var _jsApiList = [];
		if(!_hideMenu){
			_jsApiList=  [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'onMenuShareQZone'
            ];
		}
        wx.config({
            debug: false,
            appId: res.appId,
            timestamp: res.timestamp,
            nonceStr: res.nonceStr,
            signature: res.signature,
            jsApiList:_jsApiList
        });

		wx.error(function (res) {
		 // alert(res.errMsg);
		});
        wx.ready(function () {
			
			if(_hideMenu){
				wx.hideOptionMenu();
			}else
			{
				var option = {
					title:"<?php echo $wx_option['title']; ?>",
					desc:"<?php echo $wx_option['desc']; ?>",
					link: "<?php echo $wx_option['link']; ?>" || location.href,
					imgUrl: "<?php echo $wx_option['imgUrl']; ?>",
					success: function () {},
					cancel: function () {}
				};
				wx.onMenuShareAppMessage(option);
				wx.onMenuShareTimeline(option);
				wx.onMenuShareQQ(option);
				wx.onMenuShareWeibo(option);
				wx.onMenuShareQZone(option);
			}
        });
    });


});

</script>
<?php endif; ?>
<!--div style="display:none;">
<script src="http://s4.cnzz.com/stat.php?id=1260303120&web_id=1260303120" language="JavaScript"></script>
</div-->

</body>
</html>