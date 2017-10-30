<?php

namespace app\admin\controller;

use think\Controller;
use app\index\model\Seller;
use app\admin\model\Big;

class Index  extends Controller
{
	protected $seller ;
	protected $big ;

	public function _initialize()
	{
		$this->seller = new Seller();
		$this->big = new Big();
	}

	/*渲染主页*/
	public function index()
	{
		return $this->fetch();
	}

	public function home()
	{
		return $this->fetch();		
	}

	public function login()
	{
		return $this->fetch('public/login');
	}

	/*渲染类型添加的页面*/
	public function category_add()
	{
		return $this->fetch('public/category_seller_add');
	}

	/*渲染店铺列表已经通过审核商店的页面*/
	public function store()
	{
		$res = $this->seller->selectCheckedSeller('checkout' , 1);
		if($res)
		{
			foreach ($res as $key => $val) 
			{
				$big_id = $val['big_id'];
				$data = $this->big->getByField('id' , $big_id);
				if($data)
				{
					$res[$key]['big_id'] = $data[0]['style'];
				}
			}
		  
		} 
		$this->assign('seller' , $res );
		return $this->fetch('index/store');
	}

	/*渲染店铺列表已经拒绝商店的页面*/
	public function delstore()
	{
		$res = $this->seller->selectCheckedSeller('checkout' , 2);
		if($res)
		{
			foreach ($res as $key => $val) 
			{
				$big_id = $val['big_id'];
				$data = $this->big->getByField('id' , $big_id);
				if($data)
				{
					$res[$key]['big_id'] = $data[0]['style'];
				}
			}
		  
		} 
		$this->assign('seller' , $res );
		return $this->fetch('index/store');
	}

	/*渲染店铺列表待审核的商店*/
	public function checkedStore()
	{
		$res = $this->seller->selectCheckedSeller('checkout' , 0);
		if($res)
		{
			foreach ($res as $key => $val) 
			{
				$big_id = $val['big_id'];
				$data = $this->big->getByField('id' , $big_id);
				if($data)
				{
					$res[$key]['big_id'] = $data[0]['style'];
				}
			}
		}
		$this->assign('checked' , 0);
		$this->assign('seller' , $res);
		return $this->fetch('index/store');
	}

	/*驱动商家申请的信息的页面*/
	public function checkSeller()
	{
		$id = $this->request->param('id');
		$res = $this->seller->selectCheckedSeller('id' , $id)[0];	
		if(!$res)
		{
			$this->login();
			die;
		}
		$this->assign('res' , $res);
		return $this->fetch();
	}


	/*管理员对商家申请店铺做出的回应*/
	public function checkResult()
	{
		$data = $this->request->post();
		$id = $data['id'];
		$res = null;
		if($data['status'] == 1)
		{
			$res = $this->seller->check($id , 1);
		}
		else if($data['status'] == 2)
		{
			$res = $this->seller->check($id , 2);
		}
		return $res;
	}
}





















