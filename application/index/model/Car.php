<?php
namespace app\index\model;
use think\Model;
use think\Session;
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

}
