<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\User;
use app\admin\model\Administor as AdministorModel;

class Administor  extends Controller
{
	protected $admin;
	//自动触发的初始化函数
	public function _initialize()
	{				
		//$this->request = Request::instance();
		$this->admin = new AdministorModel();
		
	}

	
	// public function login()
	// {
	// 	/*$data = $_POST;*/
	// 	$data = $this->request->post();
	// 	$data = json_decode($data , true);

		/*$arr = ['status' => 1];*/
	// 	echo json_encode($data);
	// }

	public function administor()
	{	//所有的管理员
		$res = $this->admin->adminAll();
		//所有的管理员的信息
		$this->assign('res',$res);
		return $this->fetch();
	}
	//管理员个人信息
	public function selfInfo()
	{	
		$res = $this->admin->selectAdmin()[0];
		//dump($res);die;
		$this->assign('res',$res);
		return $this->fetch();
	}
}















