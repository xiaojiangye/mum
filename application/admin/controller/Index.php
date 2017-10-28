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

	/*渲染店铺列表的页面*/
	public function store()
	{
		$res = $this->seller->selectSeller();
		if($res)
		{
			foreach ($res as $key => $val) 
			{
				$big_id = $val['big_id'];
				$data = $this->big->getByField('id' , $big_id);
				if(!$data)
				{
					die;
				}
				$res[$key]['big_id'] = $data[0]['style'];
			}
			
		   $this->assign('seller' , $res );
		}
		return $this->fetch('index/store');
	}



}





















