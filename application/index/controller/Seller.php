<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use think\Request;
use app\index\model\Seller as SellerModel;

class Seller extends Controller
{
	protected $seller ;

	public function _initialize()
	{
		$this->seller = new SellerModel();
	}

	/*添加商家信息*/
	public function addSellerInfo()
	{
		$res = $this->seller->add($this->request->post());
		if($res)
		{
			return 1;
		}else{
			return 0;
		}
	}
}