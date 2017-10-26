<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Goods;
use app\admin\model\Small;
use think\Session;

class Addgoods extends Controller
{
	protected $goods ;
	protected $small;

	public function _initialize()
	{
		$this->goods = new Goods();
		$this->small = new Small();
	}

	/*驱动商家添加商品的页面*/
	public function addGoods()
	{
		return $this->fetch();
	}

	/*添加商品的详细信息*/
	public function addInfo()
	{	
		$number = Session::get('small');
		$res = $this->small->getByType('name' , $number)[0];
		if(!$res)
		{
			die;
		}
		$number = $res['big_id'] .'_' . $res['id'] . '_' . time();

		$info['number'] = $number;
		$info['name'] = Session::get('name');
		$info['picture'] = Session::get('picture');
		$info['price'] = Session::get('price');
		$info['discount'] = Session::get('discount');
		$info['stock'] = Session::get('stock');

		$res = $this->goods->add($info);
		if(!$res)
		{
			$this->error('执行错误' , 'Addgoods/addGoods');
			die;
			return 0;
		}
		$this->success('执行成功!' ,  'Addgoods/addGoods');
		
	}
}















