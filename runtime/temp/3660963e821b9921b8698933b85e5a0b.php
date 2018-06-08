<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"/home/www/kc/public/../application/index/view/wenan/view.html";i:1520322250;s:62:"/home/www/kc/public/../application/index/view/public/wxjs.html";i:1496714366;s:64:"/home/www/kc/public/../application/index/view/public/tongji.html";i:1496714366;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
        <link rel="shortcut icon" type="image/x-icon" href="http://res.wx.qq.com/mmbizwap/zh_CN/htmledition/images/icon/common/favicon22c41b.ico">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <title><?php echo $one['title']; ?></title>
		<meta name="keyword" content="<?php echo $one['title']; ?>">
		<meta name="description" content="<?php echo $one['intro']; ?>">
        <link rel="stylesheet" type="text/css" href="/static/wxeditor/view//weixin_improve.css?2015">
        <link rel="stylesheet" type="text/css" href="/static/wxeditor/view//weixin_combo.css">
        <style>
            .rich_recommend{border-bottom: 1px solid #e5e5e5;padding:5px 0;}
            .rich_recommend ul{list-style: none; padding-left: 20px;}
            .rich_recommend .right{float:right;color:#666}
			#share_read{
				text-align:center;
				position:fixed;
				margin:auto;
				left:0;
				top:0;
				width:100%;
				height:100%;
				display:none;
				background:#000;
			}
			#share_read img{max-width:100%;height:auto;}
			.rich_media_area_primary{padding: 5px 5px 15px;}

.pos-inner-box{
	width:100%;
	height:28px;
	line-height:28px;
	background:#9d8654;
	color:#fff;
}
.pos-inner-box .tit{
	width:740px;
	margin:0 auto;
}
.lzz-logo-box{
	width:100%;
	margin-top:5px;
}
.lzz-logo{
	width:740px;
	margin:0 auto;
}

@media screen and (max-width:1023px){
.pos-inner-box .tit{
	width:100%;
	margin:0 auto;
}
.lzz-logo{
	width:100%;
	margin:0 auto;
}
}

        </style>
        <!--[if lt IE 9]>
            <link rel="stylesheet" type="text/css" href="/static/wxeditor/view//weixin_improve_ie9_down.css">
        <![endif]-->
        <script src="/static/js/jquery-1.8.2.min.js"></script>


    </head>
    
    <body id="activity-detail" class="zh_CN " oncopy="alert('对不起，禁止复制！');return false;">




<?php if($is_mobile): ?>
	<div id="js_article" class="rich_media scroll" style="position:absolute; overflow:scroll; -webkit-overflow-scrolling: touch; top:0; left:0; bottom:0; right:0">
<?php else: ?>
	<div id="js_article" class="rich_media">
<?php endif; ?>


            <div id="js_top_ad_area" class="top_banner"></div>
            <div class="rich_media_inner" style="padding-bottom: 10px;">
                <div id="page-content">
                    <div id="img-content" class="rich_media_area_primary">
                        <div class="rich_media_content" id="js_content">

							<div id="content_id"><?php echo htmlspecialchars_decode($one['content']); ?></div>
						

                        </div>

							

							<?php if($one['is_show_statis'] == 1): ?>
								<div class="rich_media_tool" id="js_toobar">
                                    <?php if($is_login): ?>
                                    <a class="media_tool_meta meta_primary" id="upload" href="javascript:void(0);">上传修改</a> 
                                    <?php else: ?>
                                    <a class="media_tool_meta meta_primary" target="_blank" href="/admin/index/index?back=1">登录</a> 
                                    <?php endif; if(!empty($one['rhref'])): ?>
									<a class="media_tool_meta meta_primary" id="js_view_source" href="<?php echo $one['rhref']; ?>"><?php echo $one['rhref_text']; ?></a>
									<?php endif; ?>
									<div id="js_read_area" class="media_tool_meta tips_global meta_primary">
										阅读
										<span id="readNum"><?php echo $one['views']; ?></span>
									</div>
									<span  class="media_tool_meta meta_primary tips_global meta_praise"
									id="like">
										<i class="icon_praise_gray"></i>
										<span class="praise_num" id="likeNum"><?php echo $one['likes']; ?></span>
									</span>
									<a style="display:none" id="js_report_article"  class="media_tool_meta tips_global meta_extra"  href="javascript:void(0);">投诉<span id="reportNum" style="display:none"><?php echo $one['reports']; ?></span></a>
								</div>
								<?php endif; ?>


                    </div>
					

						
                    
                </div>
				<?php if(!$is_mobile): ?>
                <div id="js_pc_qr_code" class="qr_code_pc_outer" style="display:none;">
                    <div class="qr_code_pc_inner">
                        <div class="qr_code_pc">
                            <img class="qr_code_pc_img" src="<?php echo $one['qrcode']; ?>">
                            <p>
                                微信扫一扫
                                <br>
                                分享到朋友圈
                            </p>
							<p>
								<a href="/">返回首页</a>
							</p>
							<p>
								<a href="http://www.mobanma.com/qr.html?text=<?php echo urlencode(\think\Url::build('/index/wenan/view',array('id'=>$one['id']),'.html',true)); ?>" target="_blank">美化二维码</a>
							</p>
							
							
							
                        </div>
                    </div>
                </div>
				<?php endif; ?>



            </div>
        </div>
<?php if($is_login): ?>
<script>
    $(document).ready(function(){
    $(".edit").click(function(){
        var content = prompt("", $(this).html());
        if(content!=null){
            $(this).html(content);
        }
    })
    $("#upload").click(function(){
        if (confirm("确认修改？")) {  
        $.ajax({
            type: 'POST',
            url: '<?php echo \think\Url::build('/index/wenan/view',array('id'=>$one['id']),'.html',true); ?>',
            data: {"content":$("#content_id").html(),"edit":"edit"},
            success: function(){alert("修改成功");location.reload();},
            dataType: 'json'
        });
        }
    })
    $("#add_button").click(function(){
        $("#append").after('<p class="edit" style="margin-top: 0px; margin-bottom: 0px; padding: 0px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; color: rgb(62, 62, 62); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, Î¢ÈíÑÅºÚ, Arial, sans-serif; font-size: 15px; background-color: rgb(255, 255, 255); box-sizing: border-box !important; word-wrap: break-word !important;"></p>');
        $('.edit').unbind("click");
        $(".edit").click(function(){
        var content = prompt("", $(this).html());
        if(content!=null){
            $(this).html(content);
        }
    })
    })
$("#add_button2").click(function(){
        $("#append2").after('<p class="edit" style="margin-top: 0px; margin-bottom: 0px; padding: 0px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; color: rgb(62, 62, 62); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, ?￠èí??oú, Arial, sans-serif; font-size: 15px; background-color: rgb(255, 255, 255); box-sizing: border-box !important; word-wrap: break-word !important;"></p>');
        $('.edit').unbind("click");
        $(".edit").click(function(){
        var content = prompt("", $(this).html());
        if(content!=null){
            $(this).html(content);
        }
    })
    })

})
</script>
<?php endif; ?>
<script src="/static/js/zooming/zooming.min.js"></script>

<script>
var _id = '<?php echo $one['id']; ?>',is_like=false,is_report=false;;
    $("#like").click(function(){
        if(is_like)
            return ;
        is_like = true;
        $.ajax({
           type: "POST",
           url: "<?php echo \think\Url::build('wenan/like');?>",
           dataType: "json",
           data: {"id":_id},
           success: function(data){
               if(data.status==1)
               {
                   $("#likeNum").text(parseInt($("#likeNum").text()) + 1);
				   $(".icon_praise_gray").addClass("praised");
               }else
               {
                   //alert(  data.msg );
               }
           }
        });
    });
//zooming
	var customZooming = new Zooming({
		defaultZoomable: 'p>img',
		bgColor: 'rgb(255, 255, 255,0.4)'
	})


</script>




<script type="text/javascript">


 <?php if($is_mobile): ?>

	var overscroll = function(el) {
	  el.addEventListener('touchstart', function() {
		var top = el.scrollTop
		  , totalScroll = el.scrollHeight
		  , currentScroll = top + el.offsetHeight
		//If we're at the top or the bottom of the containers
		//scroll, push up or down one pixel.
		//
		//this prevents the scroll from "passing through" to
		//the body.
		if(top === 0) {
		  el.scrollTop = 1
		} else if(currentScroll === totalScroll) {
		  el.scrollTop = top - 1
		}
	  })
	  el.addEventListener('touchmove', function(evt) {
		//if the content is actually scrollable, i.e. the content is long enough
		//that scrolling can occur
		if(el.offsetHeight < el.scrollHeight)
		  evt._isScroller = true
	  })
	}
	overscroll(document.querySelector('.scroll'));
	document.body.addEventListener('touchmove', function(evt) {
	  //In this case, the default behavior is scrolling the body, which
	  //would result in an overflow.  Since we don't want that, we preventDefault.
	  if(!evt._isScroller) {
		evt.preventDefault()
	  }
	})

	<?php endif; ?>
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
