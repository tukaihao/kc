<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Loader;
use think\Session;
use think\Db;

class Common extends Controller
{
	public $_controller = '';//��ǰ������
    public $_action = '';//��ǰ����
    public $_timestamp = '';
	public $_user = array();
    public $_user_id = 0;
	public $_check_login = true;//�Ƿ����½
    // ��ʼ��
    protected function _initialize()
    {
		
		$this->_controller = strtolower($this->request->controller());
        $this->_action = strtolower($this->request->action());
        $this->_timestamp = $this->request->time();

		$this->assign('_controller',$this->_controller);
		$this->assign('_action',$this->_action);
		$this->assign('_timestamp',$this->_timestamp);


		 //��½���
        $this->check_login();

		$this->assign('_user',$this->_user);


		if (!Request::instance()->isAJAX())
		{
			//seo

			$this->_settings = Db::name('setting')->select();
			$settings = array(
					'name'=>'PPɨ������V1.0',	
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
				//�ϲ�������
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
		
        //�Ƿ�һ�� ����½ 
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
                    'msg'=>'��δ��½���½��ʱ�������µ�½��',
                    'status'=>0,
                );
                $this->ajaxReturn($data);

            }else
            {
				
                $this->redirect('/Admin/Index');//ȥ��½
            }
        }


		return true;
    }

	//��ȡʵʱ�û���Ϣ
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
				//�ж�״̬
				if($one['status']==2)
				{
					if($this->_check_login) //�Ƿ�һ�� ����½ 
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
