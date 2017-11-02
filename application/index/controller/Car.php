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
	protected $goods;
	public function _initialize()
	{
		$this->car = new CarModel();
		$this->goods = new Goods();
	}
	//渲染购物车页面 得到所有当前用户的购物车中的东西
	public function car()
	{	
		if(empty(Session::get('id')))
		{
			$this->redirect('User/login');
			die;
		}
		
		$info = [];
		/*得到某用户的所有购物车中的商品详细信息 及购物车中的数量*/
		$carRes= $this->car->selectCar();
		foreach ($carRes as $key => $value) 
		{
			$goods_id = $value['goods_id'];
			$data = ['goods_id' => $goods_id , 'user_id' => Session::get('id')];
			$carGoods = $this->car->getInfo($data);
			$info[$key] = $this->goods->getGoods('id' , $goods_id)[0];
			$info[$key]['count'] = $carGoods['number'];
			$info[$key]['status'] = $carGoods['status'];

		}	

		$this->assign('carGoods', $info);
		return $this->fetch();
	}


	/*把商品加入购物车*/
	public function addCar()
	{
		if(empty(Session::get('id')))
		{
			$this->redirect('User/login');
			die;
		}
		$goods_id = $this->request->post('id');
		$user_id = Session::get('id');
		$data = ['goods_id' => $goods_id , 'user_id' => $user_id];
		$res = $this->car->addCar($data);
		return $res;
	}


	/*增加购物车中已的物品的数量*/
	public function updateAddCarNum()
	{	
		$data = $this->request->post();
		$num = $this->car->updateAddCarNum($data['goods_id']);
		return json_encode($num);	
	}

	/*减少购物车中已的物品的数量*/
	public function updateSubCarNum()
	{	
		$data = $this->request->post();
		$num = $this->car->updateSubCarNum($data['goods_id']);
		return json_encode($num);	
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