<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Goods;
use app\index\model\Order as OrderModel;
class Order extends Controller
{	
	protected $order;
	protected $goods;
	public function _initialize()
	{
		$this->order = new OrderModel();
		$this->goods = new Goods();
	}
	public function order()
	{	
		//得到商品的信息
		$data = $_POST;
		dump($data);die;
		$good = $data['good_id'];
		$arr = [];
		foreach($good as $val){
			$res = $this->goods->allGoods($val);
			$arr[] = $res;
		}
		//生成订单号 根据时间戳来生成
		 $number = time();
		//清空准备结算的商品
		$this->assign('arr',$arr);
		return $this->fetch();


	}

	
}