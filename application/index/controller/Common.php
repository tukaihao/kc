<?php
namespace app\index\controller;
use think\Controller;
use think\Loader;
use think\Request;
use think\Db;
/*use think\Session;
*/
class Common extends Controller
{
	public $_controller = '';//当前控制器
    public $_action = '';//当前操作
    public $_timestamp = '';

	public $_is_mobile = false;

	public $_user = array();
    //public $_user_id = 0;
	//public $_check_login = true;//是否检查登陆
    // 初始化
    protected function _initialize()
    {
		
		$this->_controller = strtolower($this->request->controller());
        $this->_action = strtolower($this->request->action());
        $this->_timestamp = $this->request->time();

		$this->assign('_controller',$this->_controller);
		$this->assign('_action',$this->_action);
		$this->assign('_timestamp',$this->_timestamp);
		

		//微信 登陆信息 （必要时才会有,像商品码购买时）
		$this->_user = session('_user');
		if(!$this->_user){
			$this->_user = array('id'=>0,'openid'=>'');
		}
		$this->assign('_user',$this->_user);


		//浏览器判断
		$this->_is_mobile = is_mobile();
		$this->assign('is_mobile',$this->_is_mobile);

		$this->_settings = Db::name('setting')->select();

		$settings = array(
				'name'=>'PP扫码神器V1.0',	
				'copyright'=>'Copyright &copy; 2008-2017 ppsao.com',
				'beian'=>'',
				'is_touchmove'=>0,
				'touchmove_text'=>'',
				'appid'=>'',
				'appsecret'=>'',
				'is_wxpay'=>0,
				'wxpay_mchid'=>'',
				'wxpay_key'=>'',
				'wxkefu'=>'',
			);

		if(!empty($this->_settings))
		{
			$this->_settings = array_column($this->_settings,'svalue','sname');
			//合并新设置
			$this->_settings = array_merge($settings,$this->_settings);
		}else{
			$this->_settings =$settings;
		}
		
		$this->assign('settings',$this->_settings);


		//微信分享
		if($this->_is_mobile){
			$wx_option = array(
				'hideMenu'=>false,//隐藏右上角菜单接口
				'title'=>$this->_settings['name'],
				'desc'=> '查看二维码详情',
				'link'=> '',
				'imgUrl'=> SITE_URL.'/static/images/logo128.png',
			);
			$this->assign('wx_option',$wx_option);
		
		}
		

    }



}
