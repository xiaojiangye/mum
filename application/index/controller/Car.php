<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;
use think\Request;
use app\index\model\Goods;
use app\index\model\Car as CarModel;

class Car extends Controller
{	
	protected $car;
	public function _initialize()
	{
		$this->car = new CarModel();
	}
	//渲染购物车页面
	public function car()
	{	
		$res_id= $this->car->selectCar();
		 $goods = model('goods');
        $good_res = $goods->select();
        //dump($goods_res);die;
		$this->assign('res_id',$res_id);
		$this->assign('good_res',$good_res);
		return $this->fetch();
	}
	//加入购物车
	public function addcar()
	{
		$good = input('param.');
		$data = ['user_id'=> session::get('id'),'goods_id'=>$good['good']];
		$res = $this->car->where($data)->setInc('number',1);
		  if (!$res) {
		  	$this->car->data(['goods_id'=>$good['good'],'user_id'=>session::get('id')]);
			$res = $this->car->save();
		  }
		if ($res) {
			$this->redirect('index/branlist',['big'=>$big['good']]);
		}else {
			$this->error('添加失败',"index/branlist");
		}
	}

	//购物车第二步
	public function carTwo()
	{	
		$res_id= $this->car->selectCar();
		 $goods = model('goods');
        $good_res = $goods->select();
        //dump($goods_res);die;
		$this->assign('res_id',$res_id);
		$this->assign('good_res',$good_res);
		return $this->fetch();
	}

	public function number()
	{	
		//return 1;die;
		$data = $this->request->post();
		//dump($data);die;

		//生成订单号
		$number = time(); //用时间戳生成订单号

	}



	//购物车第三步
	public function carThree()
	{
		return $this->fetch();
	}
	
}