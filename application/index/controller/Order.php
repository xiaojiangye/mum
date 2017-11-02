<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;
use app\index\model\Address;
use think\Request;
use app\index\model\Goods;
use app\index\model\Car;
use app\index\model\Order as OrderModel;
class Order extends Controller
{	
	protected $order;
	protected $goods;
	protected $car;
	protected $addr;
	public function _initialize()
	{
		$this->order = new OrderModel();
		$this->goods = new Goods();
		$this->car = new Car();
		$this->addr = new Address();
	}

	/*驱动待确认购买的界面*/
	public function order()
	{
		if(empty(Session::get('id')))
		{
			$this->redirect('User/login');
			die;
		}

		$data = ['user_id' => Session::get('id') , 'is_pay' => 0];
		$info = $this->order->getOrder($data);
		//dump($info);die;
		if(!$info)
		{
			$this->redirect('Car/car');
		}
		foreach($info as $vo) {
			$money[]=$vo['payable'];
			$count[]=$vo['number'];
		}	
		//总价钱
		$acount = array_sum($money);
		//总数量
		$cou =array_sum($count);
		//收货人

		$addrRes = $this->addr->where('user_id',Session::get('id'))->order('create_time')->select();
		//dump($addrRes);
		if($addrRes){

		$this->assign('info' , $info);
		$this->assign('acount' , $acount);
		$this->assign('addrRes' , $addrRes);
		$this->assign('cou' , $cou);
		return $this->fetch();

		}else{


		//dump($info);

		$this->assign('info' , $info);
		$this->assign('acount' , $acount);
		$this->assign('cou' , $cou);
		return $this->fetch();
		}
	
	
	}

	/*确认购买进行的条件修改*/
	public function makeSure()
	{
		$data = $this->request->post('num_id');
		$data = array_unique(explode('|' , $data));
		$res = $this->order->makeSure($data);
		return json_encode($res);
	}
	

	/*得到所有选中的商品*/
	public function getAllGoods()
	{
		$goodsId = $this->request->post('good_id');
		$goods = explode('|' , $goodsId);

		/*info包含选中的物品共同生成的订单的所有信息*/
		$info = [];
		$num_id =  Session::get('id') .'-'. time();
		foreach ($goods as $key => $value) 
		{
			if($value == null)
			{
				continue;
			}
			/*得到商品id得到商品car购物车中要结算的数量*/
			$data = ['goods_id' => $value , 'user_id' => Session::get('id')];
			$car = $this->car->getInfo($data);
			//$info[$key]['status'] = $car['status'];
			$info[$key]['number'] = $car['number'];

			/*根据商品id在goods里面得到商品详细信息*/
			$goodInfo = $this->goods->getGoods('id' , $value)[0];
			$info[$key]['payable'] = $goodInfo['price']*$goodInfo['discount']*$car['number'] ;
			$info[$key]['num_id'] =  $num_id;
			$info[$key]['goods_id'] =  $value;
			$info[$key]['seller_id'] =  $goodInfo['seller_id'];
			$info[$key]['user_id'] =  Session::get('id');
		}

		/*插入数据并返回受影响的行数*/
		$checkedGoods = $this->order->addOrder($info);
		return $checkedGoods;
			
	}
	public function forder()
	{	

		return $this->fetch();
	}

	//我的订单
	public function myOrder()
	{	
		$res = $this->order->selectOrder();
		if($res){
			foreach ($res as $val) {
			$ord[]=$this->order->selectNumId($val['num_id']);
			
		}
		//dump($ord);die;
		//$numRes = $this->collect->count('id');
		$this->assign('ord',$ord);
		return $this->fetch();
		}
		else{
			return $this->fetch();
		}

	}

	//我的订单的详情页
	

	public function pay()
	{
		
	}
	//退出
	public function reorder()
	{
		return $this->fetch();
	}
	//消费中心
	public function money()
	{	
		$res =$this->order->selectMoney();
		//dump($res[0]['number']);die;
		$this->assign('res',$res);
		return $this->fetch();
	}

}