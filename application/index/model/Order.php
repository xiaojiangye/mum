<?php
namespace app\index\model;
use think\Model;
use think\Db;
use app\index\model\Goods;
use app\index\model\Car;
use think\Session;

class Order extends Model
{
	/*找到该用户所有的订单*/
	public function getOrder($data)
	{
		$res = $this->order('num_id','asc')->where($data)->select();
		if(empty($res))
		{
			return null;
		}

		$goods = new Goods();
		foreach ($res as $key => $value) 
		{
			$res[$key]['goodInfo'] = $goods->getGoods('id' , $value['goods_id'])[0];
		}
		return $res;
	}

	/*把选中的处理好的信息插入到order中 然后删除购物车中的记录  这里应该开启事务*/
	public function addOrder($info)
	{	
		$res = $this->saveAll($info);
		$car = new Car();
		if($res)
		{

			foreach ($info as $key => $value)
			{
				$r = $car->destroy(['user_id' => $value['user_id'] , 'goods_id' => $value['goods_id']]);
			}
			return $r;
		}
		return null;
		
	}


	/*确认付款之后更新订单的支付状态*/
	public function makeSure($data)
	{
		$goods = new Goods();
		foreach ($data as $key => $value)
		{
			if(empty($value))
			{
				continue;
			}
			$price = $this->field('payable')->where('num_id' , $value)->select()[0];
			$price =  $price['payable'];
			$res = $this->where('num_id' , $value)->update(['is_pay' => 1 , 'paied' => $price ]);
		}
		return $res;
	}

		

	/*得到商家在order里面的订单号 根据对应的num得到goods 然后再根据goods里面的值得到对应的信息*/
	public function getOrderInfo($data)
	{	
		/*根据商家传进来的条件得到所需的order中的信息*/
		$num = $this->field('distinct num_id ,number,paied,is_pay, create_time')->where($data)->order('create_time' , 'desc')->select();

		/*$num = $this->getNum($data);*/
		if(empty($num))
		{
			return null;
		}

		$goodInfo = null;
		/*记录订单的商品总数量和总价格*/
		$countAll = null;
		$priceAll = null;

		/*创建model中的good的对象*/
		$good = new Goods();

		/*根据商品id得到商品的具体信息*/
		/*得到每个订单对应的所有商品id及其具体信息*/
		foreach ($num as $key => $value) 
		{
			/*先得到订单中所有商品的的id 再循环处理商品id 得到商品详细信息*/
			$goodsId = $this->where(['num_id' => $value['num_id'] , 'seller_id' => $data['seller_id'] ])->select();
			if(empty($goodsId))
			{
				return null;
			}
			//dump($goodsId);
			/*根据订单编号得到所有的信息*/
			foreach ($goodsId as $k => $val) 
			{
				$goods_id = $val['goods_id'];
				$res[$k] = $good->where('id' , $goods_id)->select();
				$goodInfo[$key]['good'][$k] = $res[$k][0];
				$countAll++;
				
				//dump($res);
			}
			
			/*把订单编号和生成时间存到数组中*/
			$goodInfo[$key]['num_id'] = $value['num_id'];
			$goodInfo[$key]['create_time'] = $value['create_time'];
			$goodInfo[$key]['count'] = $value['number'];

			if($value['is_pay'] == 0)
			{
				$goodInfo[$key]['is_pay'] = '待买家付款';
			}
			else if($value['is_pay'] == 1)
			{
				$goodInfo[$key]['is_pay'] = '待发货';
			}
			else if($value['is_pay'] == 2)
			{
				$goodInfo[$key]['is_pay'] = '待收款';
			}
			else if($value['is_pay'] == 3)
			{
				$goodInfo[$key]['is_pay'] = '已完成';
			}
			
			/*得到总数量和总价格*/
			$priceAll += $value['paied'];
			$goodInfo[$key]['priceAll'] = $priceAll;
			$goodInfo[$key]['countAll'] = $countAll;
			$priceAll = 0 ;
			$countAll =0 ;
	
		}
		return $goodInfo;
	}

	/*更新订单状态*/
	public function updateState($data)
	{
		
		$res = $this->save(['is_pay' => $data['is_pay']],['num_id' => $data['num_id'] , 'seller_id' => Session::get('id')]);
		
		return $res;
	}
	//订单详情页

	public function detail($data)
	{	

		return $this->where('num_id',$data['num_id'])->field('goods_id')->select(); 
	}


	//查询订单
		public function selectOrder()
		{
			return $this->where('user_id',Session::get('id'))->field('distinct(num_id)')->group('num_id')->select();
		}
		//去重订单号 全部订单号is_pay=0
		public function selectNumId($val)
		{
			return $this->where('num_id',$val)->field('distinct(num_id),payable,create_time,is_pay')->group('num_id')->order('create_time desc')->select();
		}
		//is_pay=1
		public function selectPayz()
		{
			return $this->where('is_pay',0)->field('distinct(num_id)')->group('num_id')->select();
		}

         //is_pay=3
		// public function selectNumId($val)
		// {
		// 	return $this->where(['num_id'=>$val,'is_pay'=>3] )->field('distinct(num_id),payable,create_time,is_pay')->group('num_id')->order('create_time desc')->select();
		// }
		// public function selectPayt
		// {
		// 	return $this->where(['num_id'=>$val,'is_pay'=>2])->field('distinct(num_id),payable,create_time,is_pay')->group('num_id')->order('create_time desc')->select();
		// }
		

		//消费中心的查询
		public function selectMoney()
		{
			return $this->where('user_id',Session::get('id'))->field('distinct(num_id),payable,number')->select();
		}






}
