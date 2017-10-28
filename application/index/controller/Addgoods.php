<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Goods;
use app\admin\model\Small;
use app\index\model\Seller;
use think\Session;

class Addgoods extends Controller
{
	protected $goods ;
	protected $small;
	protected $seller;

	public function _initialize()
	{
		$this->goods = new Goods();
		$this->small = new Small();
		$this->seller = new Seller();
	}

	/*驱动商家添加商品的页面*/
	public function addGoods()
	{
		$small = $this->small->getByType('name' , '');
		$this->assign('small' , $small);
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
		$numRes = $this->goods->getGoods('number' , $number);
		
		/*商家id登录时完善*/
		$info['seller_id'] = 1;
		$info['big_id'] = 1;

		$info['small_id'] = $res['id'];
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
		$this->success('执行成功!' ,  'Addgoods/showSellerGoods');	
	}

	/*驱动小店首页 得到展示所需数据*/
	public function showSellerGoods()
	{
		$info= [];

		/*这里也先写死了店铺id*/
		$groupRes = $this->goods->groupGoods(1); 
		if(!$groupRes)
		{
			die;
		} 

		foreach ($groupRes as $key => $value) 
		{
			$info[$key]['count'] = $value['count'];
			$info[$key]['small_id'] = $value['small_id']; 

			/*得到类型的标签名*/
			$lable = $this->small->getByType('id' , $value['small_id']);
			if(!$lable)
			{
				die;
			}
			$info[$key]['lable'] = $lable[0]['name'] ;
			$obj = $this->goods->selectGoods( 'small_id' , $value['small_id']);
			$info[$key]['obj'] = $obj;
		}

		/*登录的时候存储了id name 这里先写死  */
		$seller_name = '小馋猫';
		
		//dump($info);
		$this->assign('seller_name' , $seller_name);
		$this->assign('info' , $info);
		return $this->fetch();	
	}

	/*驱动缺货统计页面*/
	public function stockGoods()
	{
		/*这里需更新卖家登录之后对应的id值*/
		$key = 'seller_id';
		$value = 1;
		$res = $this->goods->getStockGoods($key , $value);

		foreach ($res as $key => $value) 
		{
			$data = $this->small->getByType('id' , $value['small_id'])[0]['name'];
			$res[$key]['small_id'] = $data ;
		}
		$this->assign('res' , $res);
		return $this->fetch('addgoods/stockGoods');
	}


}















