<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:62:"/home/www/kc/public/../application/admin/view/wenan/index.html";i:1496714364;s:68:"/home/www/kc/public/../application/admin/view/public/base_admin.html";i:1496714364;s:64:"/home/www/kc/public/../application/admin/view/public/tongji.html";i:1496714364;}*/ ?>
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
			



	<div class="weui-panel">
		<div class="weui-panel__hd">设备码功能</div>
		<div class="weui-panel__bd">
			<div class="weui-media-box weui-media-box_text">
				<ul class="weui-media-box__info">
					<li class="weui-media-box__info__meta"><a href="<?php echo \think\Url::build('wenan/edit');?>" target="_blank">添加设备码</a></li>
					<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('wenan/cat');?>">分类管理</a></li>
				</ul>
			</div>
		</div>
	</div>


	

	<div class="weui-panel">
		
		<form id="page_form" method="get">
		<input type="submit" class="hide"/>
		<div class="weui-flex">
			<div class="weui-flex__item">
				<div class="weui-cells weui-cells_form mt0">
					<div class="weui-search-bar" id="search_bar">
						
							<div class="weui-search-bar__box">
								<i class="weui-icon-search"></i>
								<input type="search" class="weui-search-bar__input" id="search_input" name="kwd" value="<?php echo $kwd; ?>" placeholder="搜索" />
								<a href="javascript:" class="weui-icon-clear" id="search_clear"></a>
							</div>
					
						<a href="javascript:" class="weui-search-bar__cancel-btn" id="search_cancel">取消</a>
					</div>
				</div>
			</div>
			

			

			<div class="weui-flex__item">
				<div class="weui-cells weui-cells_form mt0">
				<div class="weui-cell weui-cell_select weui-cell_select-after">
					<div class="weui-cell__hd">
						<label for="" class="weui-label">选择分类</label>
					</div>
					<div class="weui-cell__bd">
						<select class="weui-select" name="cat_id">
							<option value="0">--选择分类--</option>
							<?php if(is_array($cat_arr) || $cat_arr instanceof \think\Collection): $i = 0; $__LIST__ = $cat_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<option value="<?php echo $vo['id']; ?>" <?php if($cat_id == $vo['id']): ?>selected="true"<?php endif; ?>><?php echo $vo['catname']; ?></option>
							<?php if(!empty($vo['_child'])): if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
								<option value="<?php echo $vo2['id']; ?>" <?php if($cat_id == $vo2['id']): ?>selected="true"<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;|-- <?php echo $vo2['catname']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				</div>
			</div>

			<div class="weui-flex__item">
				<div class="weui-cells weui-cells_form mt0">
						<div class="weui-cell weui-cell_vcode">
							<div class="weui-cell__hd">
								<label class="weui-label">每页显示</label>
							</div>
							<div class="weui-cell__bd">
								<input class="weui-input" type="number" name="pagesize" value="<?php echo $pagesize; ?>" placeholder="每页显示数据">
							</div>
							<div class="weui-cell__ft">
								<a href="javascript:void(0);" onclick="page_form.submit();" class="weui-vcode-btn" type="submit">确定</a>
							</div>
						</div>
				</div>
			</div>

			
			

		</div>
		</form>
		


		<div class="weui-panel__hd">设备码列表</div>
		<div class="weui-panel__bd">

			<?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<div class="weui-media-box weui-media-box_text" id="list-item-<?php echo $vo['id']; ?>">

				<h4 class="weui-media-box__title"><?php echo $vo['title']; ?></h4>
				<p class="weui-media-box__desc"><?php echo msubstr(strip_tags(htmlspecialchars_decode($vo['intro'])),0,80); ?></p>

				<ul class="weui-media-box__info">
					<li class="weui-media-box__info__meta">扫描<?php echo $vo['views2']; ?>次 ，故障<?php echo $vo['likes2']; ?>次</li>
					<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><?php echo date("Y-m-d H:i",$vo['dateline']); ?></li>
					<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('/index/wenan/view','id='.$vo['id']);?>" target="_blank">预览</a></li>
					<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="javascript:void(0);" class="list-qrcode" data-view="<?php echo \think\Url::build('/index/wenan/view',array('id'=>$vo['id']),'.html',true); ?>" data-qrcode="<?php echo $vo['qrcode']; ?>">预览二维码</a></li>
					<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('wenan/edit','id='.$vo['id']);?>" target="_blank">编辑</a></li>
					<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="javascript:void(0);" class="list-del" data-id="<?php echo $vo['id']; ?>">删除</a></li>
				</ul>
			</div>
			<?php endforeach; endif; else: echo "" ;endif; ?>


		</div>
		<div class="weui-panel__bd"><div class="pager"><?php echo $list->render(); ?></div></div>

	</div> 


<div id="dialog_qrcode" style="display:none;">
	<div class="weui-mask"></div>
	<div class="weui-dialog">
		<div class="weui-dialog__hd"><strong class="weui-dialog__title">扫一扫</strong></div>
		<div class="weui-dialog__bd"><img class="qrcode_img" src="/static/images/qrcode.png" style="max-width:250px;"/></div>
		<div class="weui-dialog__ft">
			<a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default">关闭</a>
			<a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary" target="_blank">美化二维码</a>
		</div>
	</div>
</div>



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


<script>
$(function(){
	$(".list-qrcode").click(function(){

		var _qrcode = $(this).attr("data-qrcode");
		var _view = $(this).attr("data-view");

		var $dialog = $('#dialog_qrcode');
		$dialog.find('.qrcode_img').attr("src",_qrcode);
		$dialog.fadeIn(100);
		$dialog.find('.weui-dialog__btn_default').one('click', function () {
			$dialog.fadeOut(100);
			return false;
		});
		$dialog.find('.weui-dialog__btn_primary').one('click', function () {
			$(this).attr("href","http://www.mobanma.com/qr.html?text="+_view);
			return true;
		});
	});



	$(".list-del").click(function(){
		var _id = $(this).attr("data-id");

		if(confirm("你确定删除吗?"))
		{
			_ppsao.showLoading("正在删除");
			$.ajax({
				   type: "POST",
				   url: "<?php echo \think\Url::build('del');?>",
				   data: {id:_id},
				   dataType:"json",
				   success: function(data){
					   _ppsao.hideLoading();
					   if(data.status ==1)
					   {
						   $("#list-item-"+_id).remove();
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
		}
	});
});
</script>


<!--div style="display:none;">
<script src="http://s4.cnzz.com/stat.php?id=1260303120&web_id=1260303120" language="JavaScript"></script>
</div-->

</body>
</html>