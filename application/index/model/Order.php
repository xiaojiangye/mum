<?php
namespace app\index\model;
use think\Model;
use think\Db;
use app\index\model\Goods;
use app\index\model\Car;
use think\Session;

class Order extends Model
{
	/*找到该用户所有未付款的订单*/
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

	/*把选中的处理好的信息插入到order中*/
	public function addOrder($info)
	{
		/*foreach ($info as $key => $value) 
		{
			$res = Db::table('mumma_order')->insert(['user_id' => $value['user_id'], 'goods_id' => $value['goods_id'], 'num_id' => $value['num_id'] , 'number' => $value['number'] , 'payable' => $value['payable']]);
		}*/
		$res = $this->saveAll($info);
		return $res;
	}

	/*确认付款之后更新订单的支付状态*/
	public function makeSure($data)
	{
		//$car = new Car();
		foreach ($data as $key => $value)
		{
			$this->where('num_id' , $value)->update(['is_pay' => 1]);
			if(empty($this->getError()))
			{
				/*待订单确认了之后需删除购物车中的记录*/
				$carInfo = $this->field('user_id,goods_id')->where('num_id' , $value)->select();
				foreach ($carInfo as $key => $value) 
				{
					$user_id = $value['user_id'];
					$goods_id = $value['goods_id'];
					$res = Db::execute("delete from mumma_car where user_id = $user_id and goods_id = $goods_id");
					if(!$res)
					{
						return 0;
					}
				}
			}
			else
			{
				return 0;
			}
		}
		return 1;
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


}
