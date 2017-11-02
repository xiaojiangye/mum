<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Order as OrderModel;
class Order extends Controller
{
	public function Order()
	{
		return $this->fetch();
	}
}
