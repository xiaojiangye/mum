<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;
use app\index\model\Goods;
use app\index\model\Car;
use app\index\model\Order as OrderModel;
class Order extends Controller
{	
	protected $order;
	protected $goods;
	protected $car;
	public function _initialize()
	{
		$this->order = new OrderModel();
		$this->goods = new Goods();
		$this->car = new Car();
	}
	public function order()
	{		
		//得到商品的信息
		$info = null;
		$all = [];
		$data = $_POST;
		foreach ($data['good_id'] as $key => $value) 
		{
			//var_dump($key);
			$info[$value] = $this->goods->allGoods($value)[0];
			$info[$value]['count'] = $this->car->referCar($value)[0]['number'];
			$info[$value]['status'] = $this->car->referCar($value)[0]['status'];
		}
		//dump($info);
		//生成订单号 根据时间戳和自己的id号来生成来生成
		 $number = time().Session::get('id');
		$gather = null;
	
		foreach ($info as $key => $value) 
		{
			$gather[$key]['good_id'] = $value['id'];
			$gather[$key]['number'] = $value['count'];
			$gather[$key]['user_id'] = Session::get('id');

			$gather[$key]['payable'] = $value['price'] * $value['discount'] * $value['count'];
			$gather[$key]['is_pay'] = 0;
			$gather[$key]['num_id'] = $number;
		}

		$this->order->order($gather);
		//die;

		//计算总价
		foreach($info as $money) 
		{
			$mount[]= $money['discount'] * $money['count'] * $money['price'];
			$num[]= $money['number'];
		}
		//dump($arr);
		$amount = array_sum($mount);
		$sum = array_sum($num);
		
		$number = time().Session::get('id');
		foreach ($info as $vo) {
			if(is_int($vo)) {
				 $data[] = [
					'user_id'=>session::get('id'),
					'good_id'=>$vo['id'],
					'number'=>$vo['count'],
					'is_pay'=>0,
					'num_id'=>$number,
					'payable'=>$amount
			   ];

			}
		 
		}
		$res = $this->order->order($data);
		if($res) {

		}

		

	
		//生成订单号 根据时间戳和自己的id号来生成来生成
		 $number = time().Session::get('id');

		
		/* $add = Db::table('mumma_address')->where('id',session('id'))->select();*/
	
		//清空准备结算的商品
		$this->assign('info',$info);
		$this->assign('number',$number);
		$this->assign('amount',$amount);
		$this->assign('sum',$sum);
		return $this->fetch();

	}

	public function endorder()
	{
		$data = input('param.');

		//dump($data['num_id']);die;

		$res = $this->order->where('num_id',$data['num_id'])->update(['paied'=>1]);
		if ($res) {
			$this->success('恭喜小主订单成功','order/forder');
		}else{
			$this->success('呜呜呜呜～订单失败','car/car');
		}

	}

	
}