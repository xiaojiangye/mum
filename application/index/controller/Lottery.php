<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Lottery as LotteryModel;
use think\Session;

class Lottery	extends Controller
{	
	protected $lottery;

	public function _initialize()
	{
		$this->lottery = new LotteryModel();
	}

	public function index()
	{
		return $this->fetch('lottery/lottery');
	}

	public function lottery()
	{
		if(empty(Session::get('id')))
		{
			return -1;
		}
		
		$data = $this->request->post('grade');
		$res = $this->lottery->add($data);
		return  $res;
	}

}





















