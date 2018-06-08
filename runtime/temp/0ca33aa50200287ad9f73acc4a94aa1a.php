<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"/home/www/kc/public/../application/admin/view/panel/setting.html";i:1496714364;s:68:"/home/www/kc/public/../application/admin/view/public/base_admin.html";i:1496714364;s:64:"/home/www/kc/public/../application/admin/view/public/tongji.html";i:1496714364;}*/ ?>
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
	<link rel="stylesheet" href="/static/jquery-weui/dist/css/jquery-weui.css" >
    <link rel="stylesheet" href="/static/admin/css/style.css"/>
    
<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="/static/webuploader/css/webuploader.css">

<style>

	
</style>

 </head>
<body ontouchstart>

<div class="weui-toptips weui-toptips_warn js_tooltips">错误提示</div>


<div class="weui-flex ppsao-com">
	<div class="weui-flex__item">


		<div class="weui-panel">
            <div class="weui-panel__hd">
					<ul class="right">
                        <li class="weui-media-box__info__meta"><?php echo $_user['email']; ?></li>
						<li class="weui-media-box__info__meta"><a href="<?php echo \think\Url::build('/Admin/panel/userinfo');?>">修改资料</a></li>

						<?php if($_user['id'] == 1): ?>

                        <li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('/Admin/panel/setting');?>">系统设置</a></li>
						<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('/Admin/panel/userlist');?>">管理员</a></li>

						<?php endif; ?>
						<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('/Admin/index/off');?>">退出登陆</a></li>
                    </ul>
					<?php echo (isset($settings['name']) && ($settings['name'] !== '')?$settings['name']:'快查云平台'); ?> - 管理中心
					</div>
        </div>

	


<div class="weui-row">
		<div class="weui-col-20">

			<div class="weui-panel">
				<div class="weui-panel__hd">管理菜单</div>
				<div class="weui-panel__bd">
					<div class="weui-media-box weui-media-box_small-appmsg">
						<div class="weui-cells">
							<a class="weui-cell weui-cell_access <?php if($_controller == 'panel'): ?>cell_active<?php endif; ?>"  href="<?php echo \think\Url::build('panel/index');?>">
								<div class="weui-cell__hd"><img src="/static/images/panel.png" style="width:20px;margin-right:5px;display:block"></div>
								<div class="weui-cell__bd weui-cell_primary">
									<p>主页</p>
								</div>
								<span class="weui-cell__ft"></span>
							</a>
						
						
							<a class="weui-cell weui-cell_access <?php if($_controller == 'wenan'): ?>cell_active<?php endif; ?>"  href="<?php echo \think\Url::build('wenan/index');?>">
								<div class="weui-cell__hd"><img src="/static/images/wenan.png"  style="width:20px;margin-right:5px;display:block"></div>
								<div class="weui-cell__bd weui-cell_primary">
									<p>设备码</p>
								</div>
								<span class="weui-cell__ft"></span>
							</a>
							
							

							
						</div>
					</div>
				</div>
			</div>
	
	
	</div>
	<div class="weui-col-80">
			<div class="container" id="container">
			





<form action="<?php echo \think\Url::build('setting');?>" method="post" id="save_form">

	<div class="weui-flex">
		<div class="weui-flex__item">

					<div class="weui-cells weui-cells_form mt0">
						<div class="weui-cells__title">系统设置</div>
						<div class="weui-cell">
							<div class="weui-cell__hd"><label class="weui-label">系统名称</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input" type="text" id="setting_name"  placeholder="系统名称" value="<?php echo (isset($settings['name']) && ($settings['name'] !== '')?$settings['name']:'快查云平台'); ?>"/>
							</div>
						</div>

						<div class="weui-cell">
							<div class="weui-cell__hd"><label class="weui-label">底部版权</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input" type="text" id="setting_copyright"  placeholder="底部版权" value="<?php echo (isset($settings['copyright']) && ($settings['copyright'] !== '')?$settings['copyright']:'Copyright &copy; 2008-2016 ppsao.com'); ?>"/>
							</div>
						</div>

						<div class="weui-cell">
							<div class="weui-cell__hd"><label class="weui-label">备案号</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input" type="text" id="setting_beian"  placeholder="备案号" value="<?php echo (isset($settings['beian']) && ($settings['beian'] !== '')?$settings['beian']:''); ?>"/>
							</div>
						</div>

					</div>

					<div class="weui-cells weui-cells_form">
						<div class="weui-cells__title">微信分享接口设置</div>
						<div class="weui-cell">
							<div class="weui-cell__hd"><label class="weui-label">appid</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input" type="text" id="setting_appid"  placeholder="微信接口appid" value="<?php echo (isset($settings['appid']) && ($settings['appid'] !== '')?$settings['appid']:''); ?>"/>
							</div>
						</div>

						<div class="weui-cell">
							<div class="weui-cell__hd"><label class="weui-label">appsecret</label></div>
							<div class="weui-cell__bd">
								<?php if($_user['email'] != 'test@qq.com'): ?>
								<input class="weui-input" type="text" id="setting_appsecret"  placeholder="微信接口appid" value="<?php echo (isset($settings['appsecret']) && ($settings['appsecret'] !== '')?$settings['appsecret']:''); ?>"/>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="weui-cell">
							<div class="weui-cell__hd">请在公众号设置 > 功能设置 > 设置JS接口安全域名</div>
						</div>

						<div class="weui-cells weui-cells_checkbox">
							<label class="weui-cell weui-check__label" for="setting_is_wxpay">
								<div class="weui-cell__hd">
									<input type="checkbox" class="weui-check" id="setting_is_wxpay" value="1" <?php if($settings['is_wxpay'] == 1): ?>checked="true"<?php endif; ?>>
									<i class="weui-icon-checked"></i>
								</div>
								<div class="weui-cell__bd">
									<p>开启商品码支付（* 服务号并开通微信支付）</p>
								</div>
							</label>
						</div>
						<div class="weui-cell">
							<div class="weui-cell__hd"><label class="weui-label">商户ID</label></div>
							<div class="weui-cell__bd">
								<input class="weui-input" type="text" id="setting_wxpay_mchid"  placeholder="微信接口appid" value="<?php echo (isset($settings['wxpay_mchid']) && ($settings['wxpay_mchid'] !== '')?$settings['wxpay_mchid']:''); ?>"/>
							</div>
						</div>
						<div class="weui-cell">
							<div class="weui-cell__hd"><label class="weui-label">支付密钥Key</label></div>
							<div class="weui-cell__bd">
								<?php if($_user['email'] != 'test@qq.com'): ?>
								<input class="weui-input" type="text" id="setting_wxpay_key"  placeholder="微信接口appid" value="<?php echo (isset($settings['wxpay_key']) && ($settings['wxpay_key'] !== '')?$settings['wxpay_key']:''); ?>"/>
								<?php endif; ?>
							</div>
						</div>
						

						<div class="weui-cell">
							<div class="weui-cell__bd">
								<div class="weui-uploader">
									<div class="weui-uploader__hd">
										<p class="weui-uploader__title">客服微信二维码上传</p>
									</div>
									<div class="weui-uploader__bd">
										<ul class="weui-uploader__files" id="uploaderFiles">
											<li class="weui-uploader__file" style="background-image:url(<?php echo (isset($settings['wxkefu']) && ($settings['wxkefu'] !== '')?$settings['wxkefu']:'/static/images/ico_user.png'); ?>)" id="prview-wxkefu"></li>
										</ul>
										<div class="weui-uploader__input-box">
											<input type="hidden" id="setting_wxkefu" value="<?php echo (isset($settings['wxkefu']) && ($settings['wxkefu'] !== '')?$settings['wxkefu']:''); ?>">
											<input type="hidden" id="setting_wxkefu_aid"  value="">
											<div id="picker-wxkefu" class="weui-uploader__input">选择图上传</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="weui-cell">
							<div class="weui-cell__hd">
								<p>
									参考教程：<a href="http://www.mobanma.com/news/view/id/18.html" target="_blank">微信支付设置教程</a>
								</p>
								<p>
									用户菜单设置：<br/>
									我的订单（<?php echo \think\Url::build('/index/goods/order','','.html',true);?>）
								</p>
							</div>
						</div>

						

						

					</div>


		</div>
		<div class="weui-flex__item">

				<div class="weui-cells weui-cells_form mt0">

					<div class="weui-cells__title">微信访问时：下拉背景显示设置</div>
					<div class="weui-cell weui-cell_select weui-cell_select-after">
						<div class="weui-cell__hd">
							<label for="" class="weui-label">下拉声明</label>
						</div>
						<div class="weui-cell__bd">
							<select class="weui-select" id="setting_is_touchmove" >
								<option value="0" <?php if($settings['is_touchmove'] == 0): ?>selected="true"<?php endif; ?>>不启用</option>
								<option value="1" <?php if($settings['is_touchmove'] == 1): ?>selected="true"<?php endif; ?>>启用</option>
							</select>
						</div>
					</div>

					<div class="weui-cell">
						<div class="weui-cell__hd"><label class="weui-label">声明内容</label></div>
						<div class="weui-cell__bd">
							<input class="weui-input" type="text" id="setting_touchmove_text"  placeholder="声明内容" value="<?php echo (isset($settings['touchmove_domain']) && ($settings['touchmove_domain'] !== '')?$settings['touchmove_domain']:'网页由 mp.weixin.qq.com 提供'); ?>"/>
						</div>
					</div>
					


				</div>



		</div>






	</div>

	<div class="weui-cells weui-cells_form">
		<div class="weui-cell">
			<div class="weui-cell__bd">
				<?php if($_user['email'] == 'test@qq.com'): ?>
				<button type="button" class="weui-btn weui-btn_primary" >测试不能保存</button>
				<?php else: ?>
				<button type="submit" class="weui-btn weui-btn_primary" >保存</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
</form>





			</div>

	</div>
	
</div>




	</div>
	
</div>

<div class="weui-msg__extra-area">
	<div class="weui-footer">
		<p class="weui-footer__text"><?php echo $settings['copyright']; ?></p>
	</div>
</div>


<!--BEGIN toast-->
<div id="toast" style="display: none;">
	<div class="weui-mask_transparent"></div>
	<div class="weui-toast">
		<i class="weui-icon-cancel weui-icon-cancel-no-circle weui-icon_toast"></i>
		<i class="weui-icon-success-no-circle weui-icon_toast"></i>
		<p class="weui-toast__content">已完成</p>
	</div>
</div>
<!--end toast-->

<!-- loading toast -->
<div id="loadingToast" style="display:none;">
	<div class="weui-mask_transparent"></div>
	<div class="weui-toast">
		<i class="weui-loading weui-icon_toast"></i>
		<p class="weui-toast__content">数据加载中</p>
	</div>
</div>




<script src="/static/js/jquery-1.8.2.min.js"></script>
<!-- script src="/static/weui/dist/js/zepto.min.js"></script -->
<!-- script src="/static/jquery-weui/dist/js/jquery-weui.js"></script>
<script src="/static/weui/dist/js/router.min.js"></script>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script -->
<script>
	var _ppsao = {
		
		showLoading : function(str){
			if(!str) str = "数据加载中";
			var $loadingToast = $('#loadingToast');
			if ($loadingToast.css('display') != 'none') {
				return;
			}
			$loadingToast.find(".weui-toast__content").text(str);
			$loadingToast.fadeIn(100);
		},hideLoading : function(){
			var $loadingToast = $('#loadingToast');
			$loadingToast.fadeOut(100);
		},toast:function(str,ac){
			if(!str) str = "已完成";
			var $toast = $('#toast');

			$toast.find(".weui-toast__content").text(str);
			
			var s = 1000;
			if(ac == 'forbidden'){
				s = 2000;
				$toast.find(".weui-icon-cancel-no-circle").show();
				$toast.find(".weui-icon-success-no-circle").hide();
			}else{
				$toast.find(".weui-icon-cancel-no-circle").hide();
				$toast.find(".weui-icon-success-no-circle").show();
			}
			if ($toast.css('display') != 'none') {
				return;
			}
			
			$toast.fadeIn(100);
			setTimeout(function () {
				$toast.fadeOut(100);
			}, s);

		}
	};

</script>


<!--引入JS-->
<script type="text/javascript" src="/static/webuploader/js/webuploader.js"></script>


<script>
var _form_action = '<?php echo \think\Url::build('setting');?>';

$(function(){






	$("#save_form").submit(function(){

		var _data = {
			"name":$("#setting_name").val(),
			"copyright":$("#setting_copyright").val(),
			"beian":$("#setting_beian").val(),
			"is_touchmove":$("#setting_is_touchmove").val(),
			"touchmove_text":$("#setting_touchmove_text").val(),
			"appid":$("#setting_appid").val(),
			"appsecret":$("#setting_appsecret").val(),
			"is_wxpay":$("#setting_is_wxpay").prop("checked") ? 1 : 0,
			"wxpay_mchid":$("#setting_wxpay_mchid").val(),
			"wxpay_key":$("#setting_wxpay_key").val(),
			"wxkefu":$("#setting_wxkefu").val(),
			"wxkefu_aid":$("#setting_wxkefu_aid").val()
		}
		
		_ppsao.showLoading("正在保存");


		$.ajax({
		   type: "POST",
		   url: _form_action,
		   data: _data,
		   dataType:"json",
		   success: function(data){
				_ppsao.hideLoading();

			   if(data.status ==1)
			   {
					_ppsao.toast(data.msg);
			   }else{
					_ppsao.toast(data.msg, "forbidden");
			   }
			  
		   },
		   error:function(){
				_ppsao.hideLoading();
				_ppsao.toast("请求失败，请重试", "forbidden");
		   }
		});

		return false;
	});
	
	

});


//上传
// 添加全局站点信息
var BASE_URL = '/static/webuploader',WX_UPLOAD_URL="<?php echo \think\Url::build('Fileupload/index','op=wxkefu');?>";
// 微信图片上传
jQuery(function() {
    var $ = jQuery,
        state = 'pending',
        uploader;
    uploader = WebUploader.create({
        auto: true,
        // 不压缩image
        resize: false,
        // swf文件路径
        swf: BASE_URL + '/js/Uploader.swf',
        // 文件接收服务端。
        server: WX_UPLOAD_URL,
        accept: {
            title: 'wwei upload',
            extensions: 'gif,jpg,jpeg,png'
            //,mimeTypes: 'image/*,text/*,application/*'
        },
        fileNumLimit: 1,
        fileSizeLimit: 2097152,//2 * 1024 * 1024, 
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker-wxkefu'
    });
 

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
		/*
			$percent.css( 'width', percentage * 100 + '%' );
		*/
    });


    uploader.on( 'uploadSuccess', function( file,resporse ) {

		uploader.removeFile( file );

        if(resporse.error || resporse.id<=0)
        {
            alert(resporse.error.message);
        }else if(resporse.id > 0)
        {
            $("#setting_wxkefu_aid").val(resporse.id);
			$("#setting_wxkefu").val(resporse.file_path);
            $("#prview-wxkefu").css({"backgroundImage":"url('"+resporse.file_path+"')"});
			
            
        }else
        {

            alert("T_T 上传失败，请重新上传");
        }
    });

	




});
</script>

<!--div style="display:none;">
<script src="http://s4.cnzz.com/stat.php?id=1260303120&web_id=1260303120" language="JavaScript"></script>
</div-->

</body>
</html>