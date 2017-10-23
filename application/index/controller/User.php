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

	public function regist()
	{
		return $this->fetch();
	}

	public function addUserInfo()
	{
		$data = $this->request->post();
		if($this->userModel->add($data))
		{
			return 1;
		}
		else
		{
			return 0;
		}

	}

	
}












