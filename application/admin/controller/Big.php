<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Big as BigModel; 

class Big extends Controller
{
	protected $big;

	/*自动触发的初始化函数*/
	public function _initialize()
	{
		$this->big = new BigModel();
	}

	/*检查要添加的店铺类型是否存在*/
	public function selectCategory()
	{
		$data = $this->request->post();
		$res = $this->big->getByType($data['style']);
		if($res){
			return 0;
		}else{
			return 1;
		}
		return $this->fetch('public/category_add');
	}

	/*添加店铺类型*/
	public function addCategory()
	{
		$res = $this->big->add($this->request->post());
		if($res)
		{
			return json_encode($res);
		}else{
			return 0;
		}	
	}

	/*驱动添加店铺类型的页面*/
	public function big()
	{
		$res = $this->big->selectBig();
		//dump($res);
		$this->assign('res',$res);
		return $this->fetch();
	}


}











