<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Order as OrderModel;
class Order extends Controller
{	
	protected $order;
	public function _initialize()
	{
		$this->order = new OrderModel();
	}
	public function order()
	{	
		$data = input('param.');
		dump($data);die;

	}
}