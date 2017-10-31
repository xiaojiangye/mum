<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;
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
		//dump(1);
		$good = [];
		$goods = model('goods');
		/*得到某用户的所有购物车中的商品详细信息 及购物车中的数量*/
		$carRes= $this->car->selectCar();
		
		//dump($carRes);
		foreach ($carRes as $key => $value) 
		{	dump($value);
			$goodInfo = $goods->where('id', $value['id'])->select()[0];
			//dump($goodInfo);
			$goodInfo['count'] = $carRes[$key]['number']; 
			//dump($carRes[$key]['number']);
			$good[] = $goodInfo;
		}
		//dump($carGoods);
		$this->assign('carGoods', $good);
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
			$this->success('添加成功','index/branlist');
		}else {
			$this->error('添加失败','index/branlist');
		}
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

	public function buy()
	{	

		$data = $this->request->post();
		dump($data);die;

		//生成订单号
		$number = time(); //用时间戳生成订单号

	}

	//购物车第三步
	public function carThree()
	{
		return $this->fetch();
	}
	
}