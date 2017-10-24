<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use think\Request;
use app\index\model\User as UserModel;

class User  extends  Controller
{
	protected $userModel;

	public function _initialize()
	{
		$this->userModel =  new UserModel();
	}

	/*注册时查询用户名是否存在的判断*/
	public function selectUser()
	{
		$data = $this->request->post();
		$name = $data['name'];

		if(empty($this->userModel->getName($name)))
		{
			$data = ['status' => 1];
			echo json_encode($data);
		}
	}

	/*渲染注册页面*/
	public function regist()
	{
		return $this->fetch();
	}

	/*添加注册时的个人信息*/
	public function addUserInfo()
	{
		$data = $this->request->post();
		if($this->userModel->add($data))
		{
			return 1;
		}else{
			return 0;
		}
	}

	
}












