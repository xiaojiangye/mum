<?php

namespace app\admin\controller;

use think\Controller;


class Index  extends Controller
{
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
		return $this->fetch('index/store');
	}



}





















