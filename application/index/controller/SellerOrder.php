<?php

namespace app\index\controller;
use think\Controller;
use app\index\model\Order;
use think\Session;

class SellerOrder extends Controller
{

	protected $order;

	public function _initialize()
	{
		$this->order = new Order();
	}

	/*用来驱动商家的全部商品的订单页面*/
	public function sellerOrder()
	{
		if(empty(Session::get('id')))
		{
			$this->redirect('Seller/sellogin');
			die;
		}
		$data = ['seller_id' => Session::get('id')];

		/*得到商家的所有订单的所有商品*/
		$orderInfo = $this->order->getOrderInfo($data);

		$this->assign('orderInfo' , $orderInfo);
		return $this->fetch();
	}

	/*驱动买家待付款 商家待发货  待收款  已完成订单的页面 也就是is_pay为0,1,2,3的情况*/
	public function  obligationOrder()
	{
		if(empty(Session::get('id')))
		{
			$this->redirect('Seller/sellogin');
			die;
		}

		$is_pay = $this->request->param('is_pay');	
		$data = ['seller_id' => Session::get('id') , 'is_pay' => $is_pay];
		$orderInfo = $this->order->getOrderInfo($data);

		$this->assign('orderInfo' , $orderInfo);
		return $this->fetch('seller_order/sellerOrder');
	}


	/*更新订单状态*/
	public function updateState()
	{
		$data = $this->request->post();
		
		$res = $this->order->updateState($data);

		return json_encode($res);

	}

	
}















