<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Collectgoods as CollectgoodsModel;
use think\Session;

class Collectgoods	extends Controller
{
	protected $collect;

	public function _initialize()
	{	
		$this->collect = new CollectgoodsModel();
	}

	public function addCollect()
	{
		$data = $this->request->post();
		if(empty(Session::get('id')))
		{
			$this->redirect('User/login');
			die;
		}
		$data['user_id'] = Session::get('id');
		$res = $this->collect->addCollect($data);
		return $res; 
	}
	
} 