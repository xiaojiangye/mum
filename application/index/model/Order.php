<?php
namespace app\index\model;
use think\Model;
use think\Db;
use app\index\model\Goods;

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
			/*Db::query("INSERT	INTO mumma_order( user_id,goods_id, number ,num_id, payable)  VALUES($value['user_id'], $value['goods_id'], $value['num_id'], $value['number'], ['payable'])");*/

			/*$this->user_id = $value['user_id'];
			$this->goods_id = $value['goods_id'];
			$this->num_id = $value['num_id'];
			$this->number = $value['number'];
			$this->payable = $value['payable'];*/
			//$this->status = $value['status'];
			/*$this->save();*/

			$res = Db::table('mumma_order')->insert(['user_id' => $value['user_id'], 'goods_id' => $value['goods_id'], 'num_id' => $value['num_id'] , 'number' => $value['number'] , 'payable' => $value['payable']]);
		}
		return $res;
	}








	/*public function order($gather)
	{	
		foreach ($gather as $key => $value) 
		{
			//var_dump($value);
			$this->data($value);
			 $this->save();
		}

	    //dump($data);
	    foreach ($info as $key => $value) 
		{
			
			$this->allowField(true)->data[$value];
			$this->save();
			
		}
		//var_dump($value);
		foreach ($info as $vo) {
		$data[] = [
					'user_id'=>session::get('id'),
					'good_id'=>$vo['id'],
					'number'=>$vo['count'],
					'is_pay'=>0,
					'num_id'=>$number,
					'payable'=>$amount
			   ];
		}

	}*/

}
