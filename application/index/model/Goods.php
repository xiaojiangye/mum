<?php

namespace app\index\model;
use think\Model;
use think\Db;
use app\admin\model\Big;

use app\admin\model\Small;
use think\Session;

class Goods extends Model
{
	/*添加商品*/
	public function add($info)
	{
		$this->data($info);
		$this->allowField(true)->save();
		return $this->id;
	}

	/*根据传入的条件得到产品信息*/
	public function getGoods($key , $value)
	{
		return $this->distinct(true)->field('number , id , name , seller_id , small_id , picture , price , stock ,weight, discount , description')->where($key ,  $value)->select();
	}

	/*查询商品 根据传入的条件  只用来驱动小店首页*/
	public function selectGoods($key , $value)
	{	
		$seller_id = Session::get('id');
		return Db::query("SELECT  number , id , name , seller_id , small_id , picture , price , stock , discount , description FROM mumma_goods WHERE $key = $value AND seller_id = $seller_id GROUP BY number;");
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

	/*得到缺货商品*/
	public function getStockGoods($key , $value)
	{
		return Db::query("SELECT  number , id , name , small_id , stock , description , create_time FROM mumma_goods WHERE $key = $value GROUP BY number ORDER BY stock ASC ;");
	}


	/*得到该商店销售的类型数量 以及共有多少种商品*/
	public function getCount()
	{
		$small_count = Db::table('mumma_goods')->count('distinct small_id');
		$goods_count = Db::table('mumma_goods')->count('distinct number');

		return ['small_count' => $small_count , 'goods_count' => $goods_count];
		
		/*return $this->fetchSql(true)->field('small_id , count(small_id)')->group('small_id')->select();*/
	}

	//首页查询查询商品
	/*public function selectGood($data)
	{
		$res = $this->field('name,price,discount,picture,id,small_id,big_id')->where('big_id', $data)->limit(6)->select();
		return $res;
		//dump($res);die;
	}*/

	//根据类型查商品
	public function selectList($big)
	{	
		//dump($big);
		//dump($big['big']);
		
		$res = $this->where('big_id',$big['big'])->field('distinct(number),name,price,discount,id,big_id,weight,stock,description,picture')->select();
		//dump($res);
		//die;
		//dump($res);die;
		return $res;
		
	}
	//根据商品的id得到商品的详细的信息
	public function goodsDetails($good)
	{	//默认
		$res = $this->where('id',$good['good'])->select();
		//新品
		/*$res_time =  $this->where('id',$good['good'])->desc('cteate_time')->select();
		//价钱
		$res_hot = $this->where('id',$good['good')->desc('price')->select();
		$res_*/
		return $res;
	}
	public function samePhoto($data)
	{	//dump($data);die;
		$res = $this->field('picture')->where('number',$data)->select();
		return $res;
	}
	//同款产品推荐展示前前六
	public function likeGood()
	{
		$res = $this->limit(6)->select();
		return $res;
	}

	//查询所有的商品
	public function allGoods($data)
	{	//dump($data);die;
		$res = $this->where('id',$data)->select();
		return $res;
	}

	/*更新商品信息*/
	public function updateGoods($data)
	{
		return $this->allowField(true)->save($data,['id' => $data['id']]);
	}


	/*得到某个商店的所有商品的id*/
	public function selectSellerGoods($seller_id)
	{
		return $this->field('id')->where('seller_id' , $seller_id)->order('create_time','desc')->select();
	}

	/*得到最新商品*/
	public function getLatest()
	{
		return $this->limit(4)->order('create_time')->select();
	}

   //首页根据big查询物品的信息
	public function referGoods($val)
	{
		return $this->where('id',$val)->select();
	}

	//我的收藏
	public function collection($data)
	{
		return $this->where('id',$data)->select();
	}

	//我的订单详情的关联
	// public function orderDetails()
	// {
	// 	return $this->belongTos('orderDetails');
	// }




}



















