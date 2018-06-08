<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{

	protected $rule = [
		'email' => 'require|email',
		'password'   => 'require|min:6',
		
	];

	protected $msg = [
		'email.require'        => '请填写登陆邮箱',
		'email.email'        => '登陆邮箱格式错误',
		'password.require'   => '请填写密码',
		'password.min'  => '密码长度在6位以上',
		
	];


}
