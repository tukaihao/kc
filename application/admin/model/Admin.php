<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
	 // 保存自动完成列表
    protected $auto = ['lastip'];
    // 新增自动完成列表
    protected $insert = [];
    // 更新自动完成列表
    protected $update = [];
	 // 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
    protected $autoWriteTimestamp=true;
    // 创建时间字段
    protected $createTime = 'dateline';
    // 更新时间字段
    protected $updateTime = 'updatetime';
    // 时间字段取出后的默认时间格式
    protected $dateFormat = 'Y-m-d H:i:s';
	// 字段类型或者格式转换
	protected $type = [
        'dateline'		 =>  'timestamp',
        'updatetime'     =>  'timestamp',
    ];



	protected function setLastipAttr()
	{
		return request()->ip();
	}

	/**
     *  初始化模型
     * @access protected
     * @return void
     
    protected function initialize()
    {
        
    }*/

	public static function getid(){
		return 1;
	}

}
