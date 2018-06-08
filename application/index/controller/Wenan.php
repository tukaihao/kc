<?php
namespace app\index\controller;

use think\Request;
use think\Response;
use think\Loader;
use think\Validate;
use think\Session;

class Wenan extends Common
{


	public function index()
    {
	}

    public function view()
    {

		 $id = Request::instance()->param('id/d',0);
		if($id<=0){
			$this->error("你查看的信息不存在");
		}

		$model = Loader::model('wenan');

		$map = array(
			'id'=>$id,
			'is_del'=>0,
		);
		$one = $model->where($map)->find();

		if(!$one){
			$this->error("未找到你查看的信息");
		}
		
		if(!$one['rhref_text'])//兼容旧的
		{
			$one['rhref_text'] = '阅读原文';
		}

		$data = array(
			'views'=> array('exp','views+1'),
			'views2'=> array('exp','views2+1'),
		);
		$model->where($map)->update($data);



		$this->assign('one',$one);
		

		//微信分享
		if($this->_is_mobile){
			
			$wx_option = array(
				'hideMenu'=>false,
				'title'=>$one['title'],
				'desc'=> msubstr(strip_tags(htmlspecialchars_decode($one['intro'])),0,20),
				'link'=> '',
				'imgUrl'=> $one['cover'],
			);
			$this->assign('wx_option',$wx_option);
        }

        $is_login = $this->check_login();
	$not_need_login = array(335,336,337,338,339,340,341,342,343,344);
        if(in_array($id, $not_need_login)){
            $is_login = true;
        }
        if(Request::instance()->param('edit','')=="edit" and $is_login){
            $data=array('content'=>Request::instance()->param('content',''));
            $model = Loader::model('wenan');
            $map = array(
                'id'=>$id,
            );
            $model->where($map)->update($data);
        }
        $this->assign('is_login',$is_login);

		return $this->fetch();
    }




    
    //点赞
    public function like()
    {
      
        $id = Request::instance()->param('id/d',0);

        $trans = false;
        
        $one = array();
        if($id>0 )//&& $this->_user_id>0
        {
           
			$model = Loader::model('wenan');
            $map = array(
                'id'=>$id,
                //'uid'=>$this->_user_id,
                'is_del'=>0,
            );
            $one = $model->where($map)->find();
            if($one)
            {
                $data = array(
                    'likes'=> array('exp','likes+1'),
					'likes2'=> array('exp','likes2+1'),
                );
                $trans = $model->where($map)->update($data);
            }
        }
        if($trans)
        {
			return Response::create(array(
							'status'=>1,
							'msg'=>'success',
						),'json');

          
        }else
        {
            return Response::create(array(
							'status'=>0,
							'msg'=>'error',
						),'json');
        }
        
    }
  

    
    public function check_login()
    {

		$this->_user = Session::get('_user');

        if($this->_user && $this->_user['id'] > 0)
        {
            $map = array(
				'id'=>$this->_user['id'],
				'is_del'=>0,
                'status'=>1
			);
            $model = Loader::model('admin');
			$one = $model->where($map)->find(); 

			if($one)
			{
				return true;
			}else{
				return false;
			}


        }
        return false;
    } 
}
