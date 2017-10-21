<?php

namespace app\admin\controller;

use think\Controller;

class Index  extends Controller
{
	public function index()
	{
		$this->fetch();
	}

	public function login()
	{
		return $this->fetch('public/login');
	}
}





















