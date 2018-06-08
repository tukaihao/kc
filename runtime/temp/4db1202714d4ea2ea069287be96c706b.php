<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"/home/www/kc/public/../application/admin/view/wenan/edit.html";i:1504076498;s:67:"/home/www/kc/public/../application/admin/view/public/base_weui.html";i:1496714364;s:64:"/home/www/kc/public/../application/admin/view/public/tongji.html";i:1496714364;}*/ ?>
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
    


<link href="/static/wxeditor/css/wwei_editor.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/static/wxeditor/css/jquery.jgrowl.css" />
<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="/static/webuploader/css/webuploader.css">
<style type="text/css">

  .allwin-body{
	margin:0px;
	width:100%;
	height:100%;
	overflow:hidden;
  }

</style>


 </head>
<body ontouchstart>




<div class="page__bd">

	
	<div class="weui-panel">
	<div class="weui-panel__hd">
			<ul class="right">
				<li class="weui-media-box__info__meta"><?php echo $_user['email']; ?></li>
				<li class="weui-media-box__info__meta"><a href="<?php echo \think\Url::build('/Admin/panel/userinfo');?>">修改资料</a></li>
				<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('/Admin/panel/setting');?>">系统设置</a></li>
				<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="<?php echo \think\Url::build('/Admin/index/off');?>">退出登陆</a></li>
			</ul>
			<?php echo (isset($settings['name']) && ($settings['name'] !== '')?$settings['name']:'快查云平台'); ?> - 管理中心
			</div>
	</div>


	<div class="weui-flex">
		<div class="weui-flex__item">
			
			<div class="weui-panel__hd">设备码</div>


			<form action="<?php echo \think\Url::build('save');?>" method="post" id="wxform">
			<input type="hidden" name="template_id" value="<?php echo $one['id']; ?>"/>

<div class="weui-cells weui-cells_form ">
	
	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">名称</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input" type="text"  id="wx-template-name" placeholder="名称" name="title" value="<?php echo (isset($one['title']) && ($one['title'] !== '')?$one['title']:''); ?>"/>
		</div>
	</div>
	
	


	<div class="weui-cells__title">内容</div>
	<div class="weui-cells weui-cells_form">
		<div class="weui-cell">
			<div class="weui-cell__bd">
<script id="wwei_editor" type="text/plain" style="width:99.9%;height:490px;"><?php echo htmlspecialchars_decode($one['content']); ?></script>
			</div>
		</div>
	</div>

	<div class="weui-cells__title">摘要</div>
	<div class="weui-cells weui-cells_form">
		<div class="weui-cell">
			<div class="weui-cell__bd">
				<textarea class="weui-textarea" placeholder="摘要" rows="3" name="intro"><?php echo $one['intro']; ?></textarea>
			</div>
		</div>
	</div>
	

</div>

<div class="weui-cells weui-cells_form ">

	<div class="weui-cell weui-cell_select weui-cell_select-after">
		<div class="weui-cell__hd">
			<label for="" class="weui-label">选择分类</label>
		</div>
		<div class="weui-cell__bd">
			<select class="weui-select" name="catid" id="input_cat_id">
				<option value="0">--选择分类--</option>
				<?php if(is_array($cat_arr) || $cat_arr instanceof \think\Collection): $i = 0; $__LIST__ = $cat_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<option value="<?php echo $vo['id']; ?>" <?php if($one['catid'] == $vo['id']): ?>selected="true"<?php endif; ?>><?php echo $vo['catname']; ?></option>
				<?php if(!empty($vo['_child'])): if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($i % 2 );++$i;?>
					<option value="<?php echo $vo2['id']; ?>" <?php if($one['catid'] == $vo2['id']): ?>selected="true"<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;|-- <?php echo $vo2['catname']; ?></option>
					<?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</div>
	</div>



	<div class="weui-cell">
		<div class="weui-cell__bd">
			<div class="weui-uploader">
				<div class="weui-uploader__hd">
					<p class="weui-uploader__title">图片上传 ( 300 * 300 )</p>
					<!-- div class="weui-uploader__info">0/2</div-->
				</div>
				<div class="weui-uploader__bd">
					<ul class="weui-uploader__files" id="uploaderFiles">
						<li class="weui-uploader__file" style="background-image:url(<?php echo $one['cover']; ?>)"id="prview-cover"></li>
					</ul>
					<div class="weui-uploader__input-box">
						<input type="hidden" id="attids2" name="wxqr_aid" value="">
						<input type="hidden" id="attpath2" name="wxqrcode" value="">
						<div id="picker2" class="weui-uploader__input">选择图上传</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">设备图地址</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input" placeholder="选择设备图" name="cover" value="<?php echo $one['cover']; ?>" id="wx-template-cover">
		</div>
	</div>


	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">扫描数</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input"  type="number" placeholder="请输入阅读数"  name="views" maxlength="6" value="<?php echo $one['views']; ?>">
		</div>
	</div>

	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">故障数</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input"  type="number" placeholder="请输入点赞数"  name="likes" maxlength="6" value="<?php echo $one['likes']; ?>">
		</div>
	</div>


</div>


<div class="weui-cells weui-cells_form ">
	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">作者</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input"  type="text" placeholder="请输入作者"  name="author"  value="<?php echo $one['author']; ?>">
		</div>
	</div>

	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">制作时间</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input"  type="datetime-local" placeholder="选择时间"  name="dateline"  value="<?php echo date('Y-m-d\TH:i',$one['dateline']); ?>">
		</div>
	</div>
</div>

<div class="weui-cells weui-cells_form ">
	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">说明书</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input"  type="text" placeholder="请输入"  name="rhref_text" value="<?php echo $one['rhref_text']; ?>">
		</div>
	</div>

	<div class="weui-cell">
		<div class="weui-cell__hd"><label class="weui-label">链接</label></div>
		<div class="weui-cell__bd">
			<input class="weui-input"  type="url" placeholder="请输入链接"  name="rhref" value="<?php echo $one['rhref']; ?>">
		</div>
	</div>
</div>



<div class="weui-cells weui-cells_form ">

	<div class="weui-cells__title">显示设置</div>
	<div class="weui-cells weui-cells_checkbox">

		<label class="weui-cell weui-check__label" for="is_show_title">
			<div class="weui-cell__hd">
				<input type="checkbox" class="weui-check" id="is_show_title" name="is_show_title" value="1" <?php if($one['is_show_title'] == 1): ?>checked="checked"<?php endif; ?>>
				<i class="weui-icon-checked"></i>
			</div>
			<div class="weui-cell__bd">
				<p>是否显示标题</p>
			</div>
		</label>

		<label class="weui-cell weui-check__label" for="is_show_statis">
			<div class="weui-cell__hd">
				<input type="checkbox" class="weui-check" id="is_show_statis" name="is_show_statis" value="1" <?php if($one['is_show_statis'] == 1): ?>checked="checked"<?php endif; ?>>
				<i class="weui-icon-checked"></i>
			</div>
			<div class="weui-cell__bd">
				<p>是否显示统计</p>
			</div>
		</label>

	</div>


	<div class="weui-cell">
		<div class="weui-cell__bd">
			<button type="submit" class="weui-btn weui-btn_primary" >保存</button>
		</div>
	</div>
	<br/><br/><br/>
</div>


			</form>

		</div><!--weui-flex__item-->

	</div>



</div>






<script src="/static/js/jquery-1.8.2.min.js"></script>


<script src="/static/wxeditor/css/jquery.jgrowl.min.js"></script>
<!--引入JS-->
<script type="text/javascript" src="/static/webuploader/js/webuploader.js"></script>
<script type="text/javascript" src="/static/wxeditor/js/less.js"></script>
<script type="text/javascript" src="/static/wxeditor/js/colorPicker.js"></script>
<script type="text/javascript" src="/static/wxeditor/js/ueditor1_4_3/ueditor.config.js"></script>
<script type="text/javascript" src="/static/wxeditor/js/ueditor1_4_3/ueditor.all.min.js"></script>
<script type="text/javascript" src="/static/wxeditor/js/ueditor1_4_3/9fm/9fm.v1.js"></script>
<script type="text/javascript" src="/static/wxeditor/js/ueditor1_4_3/third-party/zeroclipboard/ZeroClipboard.min.js"></script>

<script type="text/javascript" src="/static/wxeditor/js/wwei_editor.js"></script>


<script type="text/javascript">
    $(function(){
        $('#templateTab .weui-navbar__item').on('click', function () {
            $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
			
			var _type = $(this).attr("data-type");
			$("#templateTabItems .temp-panel").addClass('weui-tab__bd-item');
			$("#temp-" + _type).removeClass('weui-tab__bd-item');
        });
    });
</script>
<script type="text/javascript" >



	var less_parser = new less.Parser;
	ZeroClipboard.config({ swfPath: "/static/wxeditor/js/ueditor1_4_3/third-party/zeroclipboard/ZeroClipboard.swf" } );

	var wwei_editor = UE.getEditor('wwei_editor');

$(function () {


		/*模板Tab */
		var dataType = 'title';
		$("#wxform").submit(function(){
			var _wxid = $("#wxid").attr("data-values");
			if(_wxid<=0)
			{
				$("#wxid").focus();
				showSuccessMessage("请输选择公众号");
				return false;
			}

			if(!$("#wx-template-name").val())
			{
				$("#wx-template-name").focus();
				showSuccessMessage("请输入标题");
				return false;
			}

			


			if(wwei_editor.queryCommandState( 'source' ))
			{
				//切换到编辑模式才提交，否则有bug
				wwei_editor.execCommand('source');
			}
		
		});
		function _loadtemp(dataType){
			$("#template-loading").show();
			$.ajax({
				type: "POST",
				url: "<?php echo \think\Url::build('loadtemp');?>",
				data: {"type":dataType},
				success: function(data){
					$("#template-loading").hide();
					var tabPane = $("#temp-"+dataType);
					tabPane.html(data);
					var _tempLi = tabPane.find('.template-list li');
					_tempLi.hover(function(){
						$(this).css({"background-color":"#f5f5f5"});
					},function(){
						$(this).css({"background-color":"#fff"});
					});
					_tempLi.click(function(){
						if(dataType=='tpl')
						{
							var _tempHtml = $(this).find('.tpl-code').html();
							wwei_editor.setContent("");
							wwei_editor.execCommand('insertHtml', _tempHtml);
						}else
						{
							var _tempHtml = $(this).html();
							insertHtml(_tempHtml + "<p><br/></p>");
						}
						
					});
				}
			});
		}
		_loadtemp(dataType);//加载
		//TAB切换
		$('#templateTab a').click(function (e) {
			e.preventDefault();
			
			
			dataType = $(this).attr("data-type");
		
			if(dataType)
			{
				var tabPane = $("#temp-"+dataType);
				if(tabPane.find('.template-list').length<=0)
				{
					_loadtemp(dataType);
				}
			}
		});
		
	
		/*
		//清空
		$('#clear-editor').click(function(){
			if(confirm('是否确认清空内容，清空后内容将无法恢复')){
				wwei_editor.setContent("");
			}        
		});
		//复制
		var client = new ZeroClipboard( $('#copy-editor-html') );
		client.on( 'ready', function(event) {
			client.on( 'copy', function(event) {
				  event.clipboardData.setData('text/html', getEditorHtml());
				  event.clipboardData.setData('text/plain', getEditorHtml());
				  showSuccessMessage("已成功复制到剪切板");
			});
		});
		*/
	
		//颜色选择
		$('.colorPicker').colorPicker({
			customBG: '#222',
			init: function(elm, colors) { // colors is a different instance (not connected to colorPicker)
			  elm.style.backgroundColor = elm.value;
			  elm.style.color = colors.rgbaMixCustom.luminance > 0.22 ? '#222' : '#ddd';
			}
		});
	});


//上传
// 添加全局站点信息
var SITE_URL = "<?php echo $siet_url; ?>",BASE_URL = '/static/webuploader',WX_UPLOAD_URL="<?php echo \think\Url::build('Fileupload/index','op=menhu_cover');?>";
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
        pick: '#picker2'
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
            $("#attids2").val(resporse.id);
            $("#attpath2").val(resporse.file_path);

			var file_url = SITE_URL + resporse.file_path;
			$("#wx-template-cover").val(file_url);
            $("#prview-cover").css({"backgroundImage":"url('"+file_url+"')"});
			
            
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