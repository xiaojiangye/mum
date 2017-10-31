<?php
namespace app\index\model;
use think\Model;
use think\Session;
use think\Db;
class Car extends Model
{
	public function selectCar()
	{
		return $this->where('user_id',session::get('id'))->select();
	}

	//添加购物车 判断是否相同
	public function sameCar()
	{
		/*  $this->where('user_id',session::get('id'))->where('goods_id');*/
	}

	/*减少购物车中的商品数量*/
	public function updateAddCarNum($id)
	{
		return Db::table('mumma_car')->where('goods_id', $id)->setDec('number');
	}

	/*减少购物车中的商品数量*/
	public function updateSubCarNum($id)
	{
		return Db::table('mumma_car')->where('goods_id', $id)->setInc('number');
	}
	//查询购物车的数量
	public function referCar($val)
	{	
		return $this->where('goods_id',$val)->select();
	}

	/*添加商品到数据库*/
	public function addCar($data)
	{
		$res = $this->where($data)->select();
		if($res)
		{
			return Db::table('mumma_car')->where($data)->setInc('number');
		}
		else{

			$data['number'] = 1;
			$this->data($data);
			$this->save();
			return $this->id;
		}
	}

	/*得到对应用户的购物车中物品的值*/
	public function getInfo($data)
	{
		return $this->where($data)->select()[0];
	}



}
