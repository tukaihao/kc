<?php
namespace app\admin\controller;
use think\Request;
use think\Response;
use think\Loader;
use think\Validate;
use think\Db;
class Panel extends Common
{


    public function index()
    {
		
		return $this->fetch();
    }
	
	
	public function userdel(){

		
		if($this->_user['id'] !=1){
			return Response::create(array(
						'status'=>0,
						'msg'=>'暂无权限',
					),'json');
		}

        $id = Request::instance()->param('id/d','');

        if($id<=0)
        {
			return Response::create(array(
						'status'=>0,
						'msg'=>'请选择要删除的数据',
					),'json');

        }

		$map = array(
			'id'=>$id,
			'is_del'=>0,
		);
		$data = array(
			'is_del'=>1,
			'updatetime'=> $this->_timestamp
		);

		$model = Loader::model('admin');

		if($model->where($map)->update($data))
		{
			
			return Response::create(array(
						'status'=>1,
						'msg'=>'删除成功',
					),'json');
		
		}else
		{
			return Response::create(array(
						'status'=>0,
						'msg'=>'删除失败',
					),'json');
		}
	}
	public function useredit(){

		if($this->_user['id'] !=1){
			$this->error('暂无权限');
		}


		$id = Request::instance()->param('id/d',0);
		
		$one = array(
			'id'=>0,
			'email'=>'',
			'realname'=>'',
			'tel'=>'',
			'status'=>1,
		);
		

		$model = Loader::model('admin');

		if($id>0){
			$map = array(
				'id'=>$id,
				'is_del'=>0,
			);
			$one = $model->where($map)->find();
		}
		

		if (Request::instance()->isPost())
		{
			$email =  Request::instance()->post('email','');
            $password = Request::instance()->post('password','');
			$password2 = Request::instance()->post('password2','');
			
			
			
			$data = array(
				'updatetime'=>$this->_timestamp,
				'status'=>Request::instance()->post('status/d',0),
				'realname'=>Request::instance()->post('realname',''),
				'tel'=>Request::instance()->post('tel',''),
			);



			if($email != $this->_user['email'])
			{
				if(!Validate::is($email,'email'))
				{
					return Response::create(array(
						'status'=>0,
						'msg'=>'邮箱格式不正确',
						),'json');
				}
				$data['email'] = $email;
			}
			

			if($id <=0 || !empty($password)){

				if(!Validate::min($password,6))
				{
					return Response::create(array(
						'status'=>0,
						'msg'=>'新密码至少6位',
						),'json');
				}

				if($password != $password2){
					return Response::create(array(
						'status'=>0,
						'msg'=>'确认密码错误',
						),'json');
				}

				$data['password'] = md5_salt($password);
			}
			
			$model = Loader::model('Admin');
			
			
			if($id>0){
				$trans = $model->where(array('id'=>$id))->update($data);
			}else{
				$data['dateline'] = $this->_timestamp;
				$trans = $model->insertGetId($data);
			}
			
			if(!$trans)
			{
				return Response::create(array(
					'status'=>0,
					'msg'=>'保存失败',
					),'json');
			}
			return Response::create(array('status'=>1,'msg'=>'保存成功'),'json');

			
		}

		
		$this->assign('one', $one);


		return $this->fetch();
		

	}
	public function userlist(){
		

		if($this->_user['id'] !=1){
			$this->error('暂无权限');
		}


		$model = Loader::model('admin');

		$kwd = Request::instance()->param('kwd','');
		$pagesize = Request::instance()->param('pagesize/d',5);


        $map = array(
            'is_del'=>0,
        );
		
        if($kwd)
        {
            $map['email|realname'] = array('like','%'.$kwd.'%');
        }
		
        $list =$model->where($map)->order('id desc')->paginate($pagesize);
		
		 //分页跳转的时候保证查询条件
		foreach ($_GET as $key => $val) {
			if (!is_array($val)) {
				$list->appends($key,urlencode($val));
			}
		}


		$this->assign('kwd', $kwd);
		$this->assign('pagesize', $pagesize);
        $this->assign('list', $list);

		return $this->fetch();
	}

	public function userinfo(){
		
		if (Request::instance()->isPost())
		{
			
			if($this->_user['email'] == 'test@qq.com'){
				return Response::create(array(
						'status'=>0,
						'msg'=>'测试帐号不能保存',
						),'json');
			}
			
			$email =  Request::instance()->post('email','');
            $password = Request::instance()->post('password','');
			$password2 = Request::instance()->post('password2','');
			
			
			
			$data = array(
				'updatetime'=>$this->_timestamp,
			);

			if($email != $this->_user['email'])
			{
				if(!Validate::is($email,'email'))
				{
					return Response::create(array(
						'status'=>0,
						'msg'=>'邮箱格式不正确',
						),'json');
				}
				$data['email'] = $email;
			}
			
			if(!Validate::min($password,6))
            {
				return Response::create(array(
					'status'=>0,
					'msg'=>'新密码至少6位',
					),'json');
            }

			if($password != $password2){
				return Response::create(array(
					'status'=>0,
					'msg'=>'确认密码错误',
					),'json');
			}
			
			$model = Loader::model('Admin');
			$data['password'] = md5_salt($password);
			
			$trans = $model->where(array('id'=>$this->_user['id']))->update($data);
			
			if(!$trans)
			{
				return Response::create(array(
					'status'=>0,
					'msg'=>'保存失败',
					),'json');
			}
			return Response::create(array('status'=>1,'msg'=>'保存成功'),'json');
			
		}


		return $this->fetch();
	}



	public function setting(){
		
		
		if($this->_user['id'] !=1){
			$this->error('暂无权限');
		}


		$setting_model = Loader::model('Setting');
		
		$settings = Db::name('setting')->select();
		if(!empty($settings))
		{
			$settings = array_column($settings,'svalue','sname');
		}else{
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
		}



		if (Request::instance()->isPost())
		{


			if($this->_user['email'] == 'test@qq.com'){
				return Response::create(array(
						'status'=>0,
						'msg'=>'测试帐号不能保存',
						),'json');
			}


			$data_post = array(
				'name'=>Request::instance()->post('name',''),
				'copyright'=>Request::instance()->post('copyright',''),
				'beian'=>Request::instance()->post('beian',''),
				'is_touchmove'=>Request::instance()->post('is_touchmove',''),
				'touchmove_text'=>Request::instance()->post('touchmove_text',''),
				'appid'=>Request::instance()->post('appid',''),
				'appsecret'=>Request::instance()->post('appsecret',''),
				'is_wxpay'=>Request::instance()->post('is_wxpay/d',0),
				'wxpay_mchid'=>Request::instance()->post('wxpay_mchid',''),
				'wxpay_key'=>Request::instance()->post('wxpay_key',''),
				'wxkefu'=>Request::instance()->post('wxkefu',''),
			);

			$trans = false;

			foreach($data_post as $key=>$value)
			{

				$data = array(
					'sname'=>$key,
					'svalue'=>$value,
					'updatetime'=> $this->_timestamp
				);
				
				if(isset($settings[$key]))
				{
					
					$map = array(
						'sname'=>$key,
					);
					$trans = $setting_model->where($map)->update($data);
				
				}else{
					$trans =  $setting_model->insert($data);
				}

			}


			if(!$trans){
				return Response::create(array(
						'status'=>0,
						'msg'=>'保存失败',
						),'json');
			}
			
			
			return Response::create(array(
						'status'=>1,
						'msg'=>'保存成功',
						),'json');

			
		}

		$this->assign('settings',$settings);


		return $this->fetch();
	}


}
