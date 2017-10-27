<?php

namespace app\index\model;

use think\Model;
use think\Db;

class Goods extends Model
{
	/*添加商品*/
	public function add($info)
	{
		$this->data($info);
		$this->allowField(true)->save();
		return $this->id;
	}

	public function getGoods($key , $value)
	{
		return $this->distinct(true)->field('number , id , name , seller_id , small_id , picture , price , stock , discount , description')->where($key ,  $value)->select();
	}

	/*查询商品 根据传入的条件  只用来驱动小店首页*/
	public function selectGoods($key , $value)
	{
		
		return Db::query("SELECT  number , id , name , seller_id , small_id , picture , price , stock , discount , description FROM mumma_goods WHERE $key = $value GROUP BY number;");
	}

	/*统计每种商品类型的数量*/
	public function groupGoods($seller_id)
	{
		return Db::query("SELECT small_id , COUNT(*) as count FROM mumma_goods where seller_id = $seller_id GROUP BY small_id;");
	}

	/*根据传入的条件得到对应的所有数据*/
	public function getBySmallId( $key ,  $small_id)
	{
		return $this->where($key , $small_id)->select();
	}

}



















