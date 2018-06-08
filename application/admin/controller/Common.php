<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Loader;
use think\Session;
use think\Db;

class Common extends Controller
{
	public $_controller = '';//当前控制器
    public $_action = '';//当前操作
    public $_timestamp = '';
	public $_user = array();
    public $_user_id = 0;
	public $_check_login = true;//是否检查登陆
    // 初始化
    protected function _initialize()
    {
		
		$this->_controller = strtolower($this->request->controller());
        $this->_action = strtolower($this->request->action());
        $this->_timestamp = $this->request->time();

		$this->assign('_controller',$this->_controller);
		$this->assign('_action',$this->_action);
		$this->assign('_timestamp',$this->_timestamp);


		 //登陆检查
        $this->check_login();

		$this->assign('_user',$this->_user);


		if (!Request::instance()->isAJAX())
		{
			//seo

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
		}
    }

	public function check_login()
    {

		$this->_user = Session::get('_user');

		$is_login = false;
        if($this->_user && $this->_user['id'] > 0)
        {
            
			$this->_user = self::get_user_info($this->_user['id']);

			if($this->_user['id'] >0)
			{
				$this->_user_id = $this->_user['id'];
				$is_login = true;
			}else{
				$this->_user_id = 0;
			}


        }
		
        //是否一定 检查登陆 
        if(!$this->_check_login)
		{
			if(!$is_login)
			{
				return false;
			}else{
				return true;
			}
		}

        if(!$is_login)
        {
			if (Request::instance()->isAjax())
            {
                $data = array(
                    'msg'=>'你未登陆或登陆超时，请重新登陆！',
                    'status'=>0,
                );
                $this->ajaxReturn($data);

            }else
            {
				
                $this->redirect('/Admin/Index');//去登陆
            }
        }


		return true;
    }

	//获取实时用户信息
	public function get_user_info($user_id)
	{
		if($user_id>0)
		{
			$map = array(
				'id'=>$user_id,
				'is_del'=>0,
			);
			$model = Loader::model('Admin');
			$one = $model->field('is_del,password',true)->where($map)->find();

			if($one)
			{
				//判断状态
				if($one['status']==2)
				{
					if($this->_check_login) //是否一定 检查登陆 
					{
						$this->redirect('/Admin/Index/off');
					}else
					{
						return array();
					}
				}
				
				return $one;
			}
		}
		return array();
	}


}
