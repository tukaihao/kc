<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"/home/www/kc/public/../application/admin/view/public/dispatch_jump.html";i:1496714364;s:67:"/home/www/kc/public/../application/admin/view/public/base_weui.html";i:1496714364;s:64:"/home/www/kc/public/../application/admin/view/public/tongji.html";i:1496714364;}*/ ?>
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


<!--div style="display:none;">
<script src="http://s4.cnzz.com/stat.php?id=1260303120&web_id=1260303120" language="JavaScript"></script>
</div-->

</body>
</html>