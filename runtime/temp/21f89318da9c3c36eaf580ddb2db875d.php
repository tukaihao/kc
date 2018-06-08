<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"/home/www/kc/public/../application/index/view/index/index.html";i:1496714366;s:68:"/home/www/kc/public/../application/index/view/public/base_index.html";i:1512528729;s:62:"/home/www/kc/public/../application/index/view/public/wxjs.html";i:1496714366;s:64:"/home/www/kc/public/../application/index/view/public/tongji.html";i:1496714366;}*/ ?>
<!DOCTYPE HTML>
<html>
 <head>

        <title><?php echo $settings['name']; ?></title>
        <meta name="keyword" content="<?php echo $settings['name']; ?>">
        <meta name="description" content="<?php echo $settings['name']; ?>">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/static/weui/dist/style/weui.css"/>
    <link rel="stylesheet" href="/static/css/style.css"/>
    
<style>
.attr{color:#777777; display:inline-block; width:10%; float:left; font-size:14px;}
.attrval{display:inline-block; width:90%; float:right;font-size:14px;}
.attrdesc{color:#888}
.clear-row{clear:both; margin-bottom:10px;;}
</style>



 </head>
<body ontouchstart>

<?php if($is_mobile and $settings['is_touchmove'] == 1): ?>
	<div style="width:100%; height:100%; font-size:14px; color:#999; text-align:center; padding-top:10px;background:#2e3132" id="ppsao_domain"></div>
	<div id="scroll" style="position:absolute; overflow:scroll; -webkit-overflow-scrolling: touch; top:0; left:0; bottom:0; right:0;">
	<div style="background:#fff;min-height:100%;">
<?php endif; ?>


<div class="page__bd">
	
	<div class="weui-cells weui-cells_form mt0">
		
		 <div class="weui-panel weui-panel_access">
          
            <div class="weui-panel__bd">
                <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
                   
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title" style="font-size:14px;"><?php echo $settings['name']; ?></h4>
                    </div>
                </a>
            </div>
        </div>

	</div>
	<div class="weui-cells weui-cells_form">
		
		<div class="weui-panel weui-panel_access">
			<div class="weui-panel__bd">
				<article class="weui-article">
				
					<p>
						<h2><?php echo $settings['name']; ?></h2>
						请登陆后再制作二维码
					</p>


				</article>
			</div>
	
		</div>


	
	</div>

	


	<div class="weui-footer" style="margin-top:20px;">
		<p class="weui-footer__text"><?php echo $settings['copyright']; ?>  <a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo $settings['beian']; ?></a> </p>
	</div>




</div>





<?php if($is_mobile and $settings['is_touchmove'] == 1): ?>
	</div></div>
<?php endif; ?>



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
<!-- script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script -->
<script type="text/javascript">
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


<?php if($is_mobile and $settings['is_touchmove'] == 1): ?>

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
	  });
	  el.addEventListener('touchmove', function(evt) {
		//if the content is actually scrollable, i.e. the content is long enough
		//that scrolling can occur
		if(el.offsetHeight < el.scrollHeight)
		  evt._isScroller = true
	  })
	};
	overscroll(document.querySelector('#scroll'));
	document.body.addEventListener('touchmove', function(evt) {
	  //In this case, the default behavior is scrolling the body, which
	  //would result in an overflow.  Since we don't want that, we preventDefault.
	  if(!evt._isScroller) {
		evt.preventDefault()
	  }
	});



	$(function(){
		setTimeout(function(){$('#ppsao_domain').html('<?php echo $settings['touchmove_text']; ?>');},1000)
	});

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
