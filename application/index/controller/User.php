<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use think\Request;
use app\index\model\User as UserModel;

class User  extends  Controller
{
	protected $request ;
	protected $userModel;

	public function _initialize()
	{
		$this->request = Request::instance();
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
		$data = $this->request->post();
		$res = $this->userModel->add($data);
		if($res)
		{
			$this->success('新增成功', 'Index/index');
		}
		else
		{
			$this->error('新增失败');
		}
	}
}












