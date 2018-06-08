<?php
namespace app\index\controller;

use think\Request;
use think\Response;
use think\Loader;
use think\Validate;
use think\Session;

class Api extends Common
{

	public $_wechat=null;

	public function wechat($options = array()){
		//import('@.Org.TPWechat');
		\think\Loader::import('@.vendor.TPWechat');

		if($this->_wechat){
			return $this->_wechat;
		}
		
		if(!$options)
		{
			$options = array(
				'token'=>'',
				'encodingaeskey'=>'',
				'appid'=>$this->_settings['appid'],
				'appsecret'=>$this->_settings['appsecret'],
			);
			/*
			$options = array(
				'token'=>'', //填写你设定的key
				'encodingaeskey'=>'', //填写加密用的EncodingAESKey
				'appid'=>'wxd0b88439525952fb', //填写高级调用功能的app id
				'appsecret'=>'3376b0da577b62e5934e75d5481d7f2b' //填写高级调用功能的密钥
			);*/
		}
		$this->_wechat = new \TPWechat($options);

		return $this->_wechat;
	}
	
	public function index()
    {
	}

    public function sign()
    {

		$url = Request::instance()->get('url','http://os.ppsao.com/');

		$options = array(
			'token'=>'',
			'encodingaeskey'=>'',
			'appid'=>$this->_settings['appid'],
			'appsecret'=>$this->_settings['appsecret'],
		);
		$_wechat = $this->wechat($options);
		
		/*
		1.先获得 access_token
		2.ticket
		3.sign
		*/
		$access_token = $_wechat->checkAuth();
		$ticket = $_wechat->getJsTicket();
		$sign = $_wechat->getJsSign($url);

		if(!$sign){
			return Response::create(array(
						'status'=>0,
						'msg'=>'获取失败',
					),'json');	
		}

		return Response::create(array(
						'status'=>1,
						'msg'=>'获取成功',
						'data'=>$sign,
					),'json');	


    }



	//未登陆，来这登陆
	public function login(){
		//snsapi_userinfo  已关注的也是静默跳转





		//用于登陆后返回
		$callback = Request::instance()->param('callback','');//返回
		
		$param = '';
		if(in_array($callback,array('goods_buy','order_view','order_list'))){

			$callback_id = Request::instance()->param('callback_id/d',0);

			$param = array('callback'=>$callback,'callback_id'=>$callback_id);
		}

		$authlogin_url = \think\Url::build('Api/authlogin',$param,'.html',true);
		

		$_wechat = $this->wechat();
		$auth_url = $this->_wechat->getOauthRedirect($authlogin_url,'STATE','snsapi_userinfo');
		header('Location:'.$auth_url);
		exit;
	}

	//登陆验证
	public function authlogin(){

			
			//用于登陆后返回
			$callback = Request::instance()->param('callback','');//返回
			if(!in_array($callback,array('goods_buy','order_view','order_list'))){
				$callback = '';
			}else{
				$callback_id = Request::instance()->param('callback_id/d',0);
			}


			$_wechat = $this->wechat();

			$access_token = $this->_wechat->getOauthAccessToken(); //access_token  expires_in  refresh_token  openid  scope
			if(!$access_token){
				//$this->redirect('Api/login');
				$this->error('授权登陆失败','Api/login');
				exit;
			}
			//刷新续期
			//$this->_wechat->getOauthRefreshToken($access_token['refresh_token']);
			

			//获取 如未关注 subscribe ==0
			$user_info = $this->_wechat->getUserInfo($access_token['openid']);
			if($user_info['subscribe'] ==0){
				//授权获取
				$user_info = $this->_wechat->getOauthUserinfo($access_token['access_token'],$access_token['openid']);
				$user_info['subscribe'] = 0;
			}
			
			//print_R($user_info);exit;


			/*

//getOauthUserinfo 已关注
Array ( [openid] => oejczwB4cHFp80klrtsbhZjETw0E [nickname] => ༺陈毅锋༻ [sex] => 1 [language] => zh_CN [city] => 广州 [province] => 广东 [country] => 中国 [headimgurl] => http://wx.qlogo.cn/mmopen/OYib8f4wibOuuBFLL0YzPqd3hzWpvibYmHZDjickDK7uN7nS4DZRVs3wcSfgW552LsWQx9VWpvXVWicLoYIkbuJccfic6u6aso7Tz9/0 [privilege] => Array ( ) [unionid] => oJK2hwbReMyrWTtt9KeQICkGmn4w ) 

//getUserInfo
Array ( [openid] => oejczwB4cHFp80klrtsbhZjETw0E [nickname] => ༺陈毅锋༻ [sex] => 1 [language] => zh_CN [city] => 广州 [province] => 广东 [country] => 中国 [headimgurl] => http://wx.qlogo.cn/mmopen/OYib8f4wibOuuBFLL0YzPqd3hzWpvibYmHZDjickDK7uN7nS4DZRVs3wcSfgW552LsWQx9VWpvXVWicLoYIkbuJccfic6u6aso7Tz9/0 [subscribe_time] => 1474782372 [unionid] => oJK2hwbReMyrWTtt9KeQICkGmn4w  [subscribe] => 1  [remark] => [groupid] => 0 [tagid_list] => Array ( ) )


//getOauthUserinfo 未关注 
Array ( [openid] => oejczwB4cHFp80klrtsbhZjETw0E [nickname] => ༺陈毅锋༻ [sex] => 1 [language] => zh_CN [city] => 广州 [province] => 广东 [country] => 中国 [headimgurl] => http://wx.qlogo.cn/mmopen/OYib8f4wibOuuBFLL0YzPqd3hzWpvibYmHZDjickDK7uN7nS4DZRVs3wcSfgW552LsWQx9VWpvXVWicLoYIkbuJccfic6u6aso7Tz9/0 [privilege] => Array ( ) [unionid] => oJK2hwbReMyrWTtt9KeQICkGmn4w ) 

//getUserInfo
Array ( [subscribe] => 0 [openid] => oejczwB4cHFp80klrtsbhZjETw0E [unionid] => oJK2hwbReMyrWTtt9KeQICkGmn4w [tagid_list] => Array ( ) )


				Array ( [openid] => oJtLhvy5aBgplqMQXjlR82IAJddo [nickname] => ༺陈毅锋༻ [sex] => 1 [language] => zh_CN [city] => Guangzhou [province] => Guangdong [country] => CN [headimgurl] => http://wx.qlogo.cn/mmopen/tGVeRxry10MXltXCeMjyAY9pfAEC2icYIpCQ8ia2IITWC7egYUO0WbQ38C9n7IJHniaElcO4ADicxZrKwLtIkBqHte14tJ8MmEFV/0 [privilege] => Array ( ) )
			*/


/*

//test 
			$access_token = array(
				'refresh_token'=>'refresh_token',
				'access_token'=>'access_token',
				'openid'=>'openid',
				'scope'=>'scope',
			);
			$user_info =array(
				'unionid'=>'oJtLhvyddo',
				'openid'=>'oJtLhvy5aBgplqMQXjlR82IAJddo',
				'nickname'=>'༺陈毅锋༻',
				'sex'=>'1',
				'language'=>'zh_CN',
				'city'=>'广州市',
				'province'=>'广东省',
				'country'=>'CN',
				'headimgurl'=>'http://wx.qlogo.cn/mmopen/tGVeRxry10MXltXCeMjyAY9pfAEC2icYIpCQ8ia2IITWC7egYUO0WbQ38C9n7IJHniaElcO4ADicxZrKwLtIkBqHte14tJ8MmEFV/0',
				'privilege'=>array(),
			);


//test end*/

			if(!$user_info['openid']){
				$this->error('登陆失败，请重新打开。');
			}


			$mpuser_one = array(
				'unionid'=>isset($user_info['unionid']) ? $user_info['unionid'] : '',
				'openid'=>$user_info['openid'],
				'nickname'=>$user_info['nickname'],
				'headimgurl'=>$user_info['headimgurl'],
				'sex'=>$user_info['sex'],
				'language'=>$user_info['language'],
				'city'=>$user_info['city'],
				'province'=>$user_info['province'],
				'country'=>$user_info['country'],

				'access_token'=>$access_token['access_token'],
				'expires_in'=>$this->_timestamp + $access_token['expires_in'],
				'refresh_token'=>$access_token['refresh_token'],
				'scope'=>$access_token['scope'],
				'subscribe'=>(int)$user_info['subscribe'],
				'updatetime'=>$this->_timestamp
			);
 
			//print_R($mpuser_one);exit;
			session('_user',$mpuser_one);

			
			if($callback =='goods_buy'){
				$this->redirect('goods/buy',array('id'=>$callback_id));

			}else if($callback =='order_view'){
				$this->redirect('goods/order_view',array('id'=>$callback_id));

			}else if($callback =='order_list'){
				$this->redirect('goods/order');

			}
			else{
				//登陆成功，跳转到应用主页
				header('Location:/');
			}

			exit;

	}
	
}
