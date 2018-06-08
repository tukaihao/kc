<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:62:"/home/www/kc/public/../application/admin/view/index/index.html";i:1503026098;s:67:"/home/www/kc/public/../application/admin/view/public/base_weui.html";i:1496714364;s:64:"/home/www/kc/public/../application/admin/view/public/tongji.html";i:1496714364;}*/ ?>
<!DOCTYPE HTML>
<html>
 <head>

        <title><?php echo (isset($settings['name']) && ($settings['name'] !== '')?$settings['name']:'快查云平台'); ?></title>
        <meta name="keyword" content="">
        <meta name="description" content="">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/static/weui/dist/style/weui.css"/>
    <link rel="stylesheet" href="/static/css/style.css"/>
    

<style>
	.weui-cells_form{
		max-width:500px;
		margin:0 auto;
		border-left:1px solid #D9D9D9;
		border-right:1px solid #D9D9D9;
	}

	.page{
		border-top:2px solid #3cc51f;
	}
	.page .page__title,.page .page__desc{text-align:center;}
</style>

 </head>
<body ontouchstart>




<div class="container" id="container">

	<div class="page">

		<div class="page__hd">
			<h1 class="page__title"><?php echo (isset($settings['name']) && ($settings['name'] !== '')?$settings['name']:'快查云平台'); ?></h1>
			<p class="page__desc">管理中心</p>
		</div>


		<div class="weui-cells weui-cells_form">
		<form action="<?php echo \think\Url::build('login');?>" method="post">
			<div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">登陆邮箱</label></div>
				<div class="weui-cell__bd">
					<input class="weui-input" type="email" name="email"  placeholder="登陆邮箱" value="<?php echo $auth_login_email; ?>"/>
				</div>
			</div>
			<div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">登陆密码</label></div>
				<div class="weui-cell__bd">
					<input class="weui-input" type="password" name="password"  placeholder="登陆密码" autocomplete="off"/>
				</div>
			</div>
			

			<div class="weui-cell weui-cell_vcode">
				<div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
				<div class="weui-cell__bd">
					<input class="weui-input" type="number" name="captcha" placeholder="请输入验证码"/>
				</div>
				<div class="weui-cell__ft">
					<img class="weui-vcode-img" src="<?php echo captcha_src(); ?>" onclick="this.src='<?php echo captcha_src(); ?>?d='+Math.random();" alt="验证码" title="点击更换"/>
				</div>
			</div>
			
			<div class="weui-cell">
				<button type="submit" class="weui-btn weui-btn_primary">登陆</button>
			</div>

			<div class="weui-cell">
				<p class="page__desc">&copy;2016 <?php echo $_SERVER['HTTP_HOST']; ?> 版权所有</p>
			</div>
		</form>
	
		</div>
		


	</div>

</div>








<script src="/static/admin/js/index.js"></script>


<!--div style="display:none;">
<script src="http://s4.cnzz.com/stat.php?id=1260303120&web_id=1260303120" language="JavaScript"></script>
</div-->

</body>
</html>