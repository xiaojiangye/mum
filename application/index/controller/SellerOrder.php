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
	public function SellerOrder()
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

	/*驱动买家待付款的页面*/
	public function 



	/*驱动商家待发货的页面*/

	/*驱动商家已完成的页面*/
	
}















