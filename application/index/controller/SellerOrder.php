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

	/*用来驱动商家的全部商品的页面*/
	public function SellerOrder()
	{
		if(empty(Session::get('id')))
		{
			$this->redirect('Seller/sellogin');
			die;
		}
		$data = ['seller_id' => Session::get('id')];
		//$sellerOrder = $this->order->getSellerOrder($data);
		
		return $this->fetch();
	}
	
}















