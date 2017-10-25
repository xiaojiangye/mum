<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Administor  extends Controller
{
	protected $request;

	public function _initailize()
	{				
		$this->request = Request::instance();
	}

	
	public function login()
	{
		/*$data = $_POST;*/
		$data = $this->request->post();
		$data = json_decode($data , true);

		/*$arr = ['status' => 1];*/
		echo json_encode($data);
	}

}















