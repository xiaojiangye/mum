<?php

namespace app\admin\controller;

use think\Controller;

class Index  extends Controller
{
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

	public function category_add()
	{
		return $this->fetch('public/category_seller_add');
	}



}





















