<?php
namespace app\admin\controller;
use think\Request;
use think\Response;
use think\Loader;
use think\Validate;
use think\Db;

class Wenan extends Common
{

	
	public function loadtemp()
	{
		$type = $kwd = Request::instance()->param('type','');
		if(!in_array($type,array('title','text','img','tpl','scene','follow')))
		{
			echo '错误的模板类型 T_T';
			exit;
		}
	
		$this->assign('siet_url',SITE_URL);

		return $this->fetch('temp_'.$type);

	}


    public function index()
    {

		$model = Loader::model('wenan');

		$kwd = Request::instance()->param('kwd','');
		$pagesize = Request::instance()->param('pagesize/d',5);
		$cat_id = Request::instance()->param('cat_id/d',0);


        $map = array(
            'is_del'=>0,
        );
		if($cat_id>0){
			$map['catid'] = $cat_id;
		}
		
        if($kwd)
        {
            $map['title'] = array('like','%'.$kwd.'%');
        }
		
        $list =$model->where($map)->order('id desc')->paginate($pagesize);
		
		 //分页跳转的时候保证查询条件
		foreach ($_GET as $key => $val) {
			if (!is_array($val)) {
				$list->appends($key,urlencode($val));
			}
		}


		$this->assign('cat_id', $cat_id);
		$this->assign('kwd', $kwd);
		$this->assign('pagesize', $pagesize);
        $this->assign('list', $list);

		

		//分类
		$cat_arr = Db::name('wenan_cat')->where(array('is_del'=>0))->order('nav_sort desc,id asc')->select();
		$cat_arr = list_to_tree($cat_arr);
		$this->assign('cat_arr',$cat_arr);


		return $this->fetch();
    }
	public function del(){

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

		$model = Loader::model('wenan');

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


	public function edit(){
		
		$id = Request::instance()->param('id/d',0);
		
		$one = array(
			'id'=>0,
			'catid'=>0,
			'title'=>'',
			'author'=>'',
			'cover_aid'=>0,
			'cover'=>'',
			'intro'=>'',
			'content'=>'',
			'rhref'=>'',
			'rhref_text'=>'阅读原文',
			'hao_name'=>'',
			'hao_url'=>'',
			'views'=>0,
			'likes'=>0,
			'reports'=>0,
			'views2'=>0,
			'likes2'=>0,
			'is_vip'=>0,
			'is_show_title'=>1,
			'is_show_statis'=>1,
			'dateline'=>$this->_timestamp
		);
		
		$model = Loader::model('wenan');

		if($id>0){
			$map = array(
				'id'=>$id,
				'is_del'=>0,
			);
			$one = $model->where($map)->find();
		}
		

		$this->assign('one',$one);

		//分类
		$cat_arr = Db::name('wenan_cat')->where(array('is_del'=>0))->order('nav_sort desc,id asc')->select();
		$cat_arr = list_to_tree($cat_arr);
		$this->assign('cat_arr',$cat_arr);

		
		$this->assign('siet_url',SITE_URL);

		return $this->fetch();
		
	}



	public function save(){
	
	
		
		$dateline = Request::instance()->param('dateline','');
		if($dateline)
		{
			$dateline = strtotime($dateline);
		}
		if(!$dateline)
		{
			$dateline = $this->_timestamp;
		}
		
		$id = Request::instance()->param('template_id/d',0);
		

        $data = array(
            'uid'=>$this->_user_id,
            'title'=>Request::instance()->param('title',''),
            'content'=>Request::instance()->param('editorValue',''),
			'intro'=>Request::instance()->param('intro',''),
			'author'=>Request::instance()->param('author',''),
			'cover'=>Request::instance()->param('cover',''),
			'catid'=>Request::instance()->param('catid/d',0),
			'rhref'=>Request::instance()->param('rhref',''),
			'rhref_text'=>Request::instance()->param('rhref_text',''),
			'is_show_title'=>Request::instance()->param('is_show_title/d',0),
			'is_show_statis'=>Request::instance()->param('is_show_statis/d',0),
			'is_vip'=>1,
			'views'=>Request::instance()->param('views/d',0),
			'likes'=>Request::instance()->param('likes/d',0),
			'is_tmp'=>0,
            'updatetime'=>$this->_timestamp,
			'dateline'=>$dateline
        );

		$wxqr_aid = Request::instance()->param('wxqr_aid/d',0);
		//附件二维码
		if($wxqr_aid>0)
		{
			//验证aid
			$map = array(
				'id'=>$wxqr_aid,
				//'uid'=>$this->_user_id,
				'is_del'=>0
			);
			$att_one = Db::name('attachment')->field('id,file_path')->where($map)->find();
			if(!$att_one)
			{
				$wxqr_aid = 0;
				$att_one = array();
				//$this->error('请上传公众号二维码图片!');
			}
		}

    
		$model = Loader::model('wenan');

		$one = array('cover_aid'=>0);

        if($id>0)
        {
            $map = array(
                'id'=>$id,
                //'uid'=>$this->_user_id,
                'is_del'=>0,
            );
            $one = $model->where($map)->find();

			 if(!$one)
			{
				$this->error('未找到编辑的数据');
			}

        }

	


 
        
		if($wxqr_aid>0)
		{
			$data['cover_aid'] = $wxqr_aid;
			$data['cover'] = SITE_URL.$att_one['file_path'];
			//把旧的改为无效
			if($wxqr_aid !=$one['cover_aid'])
			{
				Db::name('attachment')->where(array('id'=>$one['cover_aid'],'uid'=>$this->_user_id))->update(array('is_del'=>1));
			}
		}

	
        if($id>0)
        {
            $map = array(
                'id'=>$id,
                //'uid'=>$this->_user_id,
                'is_del'=>0,
            );
            $model->where($map)->update($data);
        }else
        {
            $id = $model->insertGetId($data);
			//生成二维码
			if($id > 0){
				//生成预览二维码
				$qrcode_text = \think\Url::build('/index/wenan/view',array('id'=>$id),'.html',true);
				$qrcode = my_phpqrcode($qrcode_text);
				$data = array(
					'qrcode'=>$qrcode,
					'updatetime'=>$this->_timestamp,
				);
				$map = array(
					'id'=>$id,	
				);
				$model->where($map)->update($data);
			}

        }

		$this->success('保存成功',\think\Url::build('/index/wenan/view',array('id'=>$id),'.html',true));



	}






	public function cat(){
	

		$model = Loader::model('wenan_cat');

		$kwd = Request::instance()->param('kwd','');
		$pid = Request::instance()->param('pid/d',0);
		$pagesize = Request::instance()->param('pagesize/d',5);

        $map = array(
			'pid' => $pid,
            'is_del'=>0,
        );
		
        if($kwd)
        {
            $map['catname'] = array('like','%'.$kwd.'%');
        }
		
        $list =$model->where($map)->order('nav_sort desc,id asc')->paginate($pagesize);
		
		 //分页跳转的时候保证查询条件
		foreach ($_GET as $key => $val) {
			if (!is_array($val)) {
				$list->appends($key,urlencode($val));
			}
		}

		$this->assign('pid', $pid);
		$this->assign('kwd', $kwd);
		$this->assign('pagesize', $pagesize);
        $this->assign('list', $list);

		return $this->fetch();
	}
	
	public function cat_del(){

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

		$model = Loader::model('wenan_cat');

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



	public function cat_edit(){
		
		$id = Request::instance()->param('id/d',0);
		$pid = Request::instance()->param('pid/d',0);
		
		$one = array(
			'id'=>0,
			'pid'=>$pid,
			'catname'=>'',
			'nav_sort'=>10
		);
		

		$model = Loader::model('wenan_cat');

		if($id>0){
			$map = array(
				'id'=>$id,
				'is_del'=>0,
			);
			$one = $model->where($map)->find();
		}
		

		if (Request::instance()->isPost())
		{

			$data = array(
				'pid'		=> $pid,
				'catname'	=> Request::instance()->post('catname',''),
				'nav_sort'	=> Request::instance()->post('nav_sort/d',''),
			);

			if(empty($data['catname'])){
				return Response::create(array(
							'status'=>0,
							'msg'=>'请填写分类名称',
						),'json');
			}

			if($one['id'] > 0){
				$map = array(
					'id'=>$one['id'],	
				);
				$data['updatetime'] = $this->_timestamp;
				$trans = $model->where($map)->update($data);
			}else{
				$data['dateline'] = $this->_timestamp;
				$one['id'] = $trans = $model->insertGetId($data);
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
						'data'=>array('id'=>$one['id'],'href'=>\think\Url::build('wenan/cat_edit','id='.$one['id'])),
					),'json');

			
		}

		//上级分类列表
		$map = array(
			'pid'=>0,
			'is_del'=>0,
		);
		$parent_arr =$model->where($map)->order('nav_sort desc,id asc')->select();
		

		$this->assign('pid',$pid);
		$this->assign('one',$one);
		$this->assign('parent_arr',$parent_arr);


		return $this->fetch();
		
	}

}
