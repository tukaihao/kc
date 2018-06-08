<?php
namespace app\admin\controller;

use think\Request;
use think\Validate;
use think\Cookie;
use think\Session;
use think\Loader;
use think\Url;

//use app\admin\model\Admin;

class Index extends Common
{
	public $_check_login = false;//是否检查登陆

    public function index()
    {
	
		$auth_login_email = Cookie::get('auth_login_email');
        $this->assign('auth_login_email',$auth_login_email);
 
/*
验证
$data = [
    'password'   => '11111',
    'email' => 'thinkphp@qq.com',
];

$validate = Loader::validate('Login');
if(!$validate->check($data)){
    dump($validate->getError());
	exit;
}
*/


/*
添加数据模型
$user = Loader::model('Admin');
$user->email = 'ThinkPHP';
$user->save();
echo $user->username; // thinkphp
echo $user->dateline; // 1
exit;*/

		//echo Admin::getid();exit;

		//$admin_model = new Admin;
		//echo $admin_model->getid();exit;

		//$admin_model = Loader::model('Admin');
		//echo $admin_model->getid();exit;

		//$a = Validate::is('aaa@qq.com','email');
		//$a = Validate::min('abc',6);
		//var_dump($a);exit;
		//echo \think\Url::build('hello');;exit;
		
		//$model = \think\Loader::model('Admin');

		//$model->insert(array('username'=>111,'email'=>''));

		return $this->fetch();
    }


	public function json2(){

		//return \think\Response::create(array('status'=>1,'data'=>array('aa'=>11)),'json');


		
	}


	public function off(){
		Session::set('_user',null);
        Cookie::set('login_auth_data',null);
        Cookie::set('login_auth_key',null);
        $this->success('您已退出登陆',Url::build('index'),'',1);
	}
	public function login(){
		
		if (!Request::instance()->isPost())
		{
			$this->error('请登陆',Url::build('index'),'',1);
		}
		else
        {
			
			$captcha =  Request::instance()->post('captcha','');
			if(!captcha_check($captcha)){
				$this->error('验证码输入错误！');
			};
		
            $email =  Request::instance()->post('email','');
            $password = Request::instance()->post('password','');

            if(!Validate::is($email,'email'))
            {
                $this->error("邮箱格式不正确");
            }
			//保持用户名
			Cookie::set('auth_login_email',$email,2592000);


            if(!Validate::min($password,6))
            {
                $this->error("请输入6位以上登陆密码");
            }

           

            $map = array(
                'email'=>$email,
                'is_del'=>0,
            );

			$model = Loader::model('Admin');

            if(!$row = $model->where($map)->find())
            {
                $this->error("未找到登陆邮箱,请重试");
            }

		
            if(md5_salt($password) != $row['password'])
            {
                $this->error('密码不正确,请重试');
            }
            
            if($row['status']==2)
            {
                $this->error('帐号已经锁定，如有疑问，请联系本站');
            }
            
            
            $ip = get_client_ip();
		

            $data = array(
				'username'=>'',
                'lasttime'=>$this->_timestamp,
                'lastip'=>$ip,
                'logins'=> array('exp','logins+1'),
            );
            
            $model->where(array('id'=>$row['id']))->update($data);
            
            
            $row['lasttime'] = $row['lasttime']>0 ? $row['lasttime'] : $this->_timestamp;
            Session::set('_user',$row);

            $this->success("登陆成功",Url::build('/Admin/panel'),'',2);
            exit;
        }


		
	}



}
