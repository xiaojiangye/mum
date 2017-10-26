<?php
namespace app\index\controller;

use think\Controller; 
use think\View;
use think\Request;
use app\index\model\Seller as SellerModel;
use app\admin\model\Big;

class Seller extends Controller
{
	protected $seller ;
	protected $big;
	

	public function _initialize()
	{
		$this->seller = new SellerModel();
		$this->big = new Big();
	}

	/*添加商家信息  先查出可以注册成哪种商家*/
	public function addSellerInfo()
	{	
		$post = $this->request->post();
		$style = $post['style'];
		$res = $this->big->getByType($style);
		$post['big_id'] = $res[0]['id'];
		$post['name'] = $post['uname'];
		$res = $this->seller->add($post);
		return json_encode($res);
		if($res)
		{
			return 1;
		}else{
			return 0;
		}
	}
	

	/*渲染商家中心的页面  小店信息*/
	public function selInfo()
	{
		return  $this->fetch();
	}

}