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
		foreach ($info as $key => $value) 
		{

			$res = Db::table('mumma_order')->insert(['user_id' => $value['user_id'], 'goods_id' => $value['goods_id'], 'num_id' => $value['num_id'] , 'number' => $value['number'] , 'payable' => $value['payable']]);
		}
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

		public function selectOrder()
		{
			return $this->where('user_id',Session::get('id'))->select();
		}
		public function selectNumId($val)
		{
			return $this->where('num_id',$val)->select();
		}

}
