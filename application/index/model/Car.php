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

}
