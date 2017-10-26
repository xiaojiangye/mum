<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Goods;
use app\admin\model\Small;
use think\Session;

class Addgoods extends Controller
{
	protected $goods ;
	protected $small;

	public function _initialize()
	{
		$this->goods = new Goods();
		$this->small = new Small();
	}

	/*驱动商家添加商品的页面*/
	public function addGoods()
	{
		return $this->fetch();
	}

	/*添加商品的详细信息*/
	public function addInfo()
	{	
		$number = Session::get('small');
		$res = $this->small->getByType('name' , $number)[0];
		if(!$res)
		{
			die;
		}
		$number = $res['big_id'] .'_' . $res['id'] . '_' . time();


		$info['number'] = $number;
		$info['name'] = Session::get('name');
		$info['picture'] = Session::get('picture');
		$info['price'] = Session::get('price');
		$info['discount'] = Session::get('discount');
		$info['stock'] = Session::get('stock');

		$res = $this->goods->add($info);
		dump($res);
		if(!$res)
		{
			$this->error('执行错误' , 'Addgoods/addGoods');
			die;
			return 0;
		}
		$this->success('执行成功!' ,  'Addgoods/addGoods');
		
	}

	
	/*测试 得到测试页面提交过来的数据 对图片进行上传*/
	public function uploadPicture()
	{	
		//$file = request()->file('picture');
		

		// 移动到框架应用根目录/public/uploads/ 目录下
		/*$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads/goods');
		if($info)
		{
			$post['picture'] = $info->getSaveName().'<br />';
		}
		else{
			// 上传失败获取错误信息
			echo $file->getError();
		}
*/
		/*$res = $this->addInfo($post);
		if(!$res)
		{
			$this->error('执行错误' , 'Addgoods/addGoods');
			die;
		}
		$this->success('执行成功!' ,  'Addgoods/addGoods');*/
	}
}















