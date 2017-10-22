<?php

namespace app\admin\controller;

use think\Controller;

class Big  extends  Controller
{
	/*添加店铺类型*/
	public function category_add ()
	{
		return $this->fetch('public/category_add');
	}

}











