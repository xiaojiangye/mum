<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Goods;
use app\admin\model\Small;
use app\index\model\Seller;
use think\Session;
use app\index\controller\Index;

class Addgoods extends Controller
{
	protected $goods ;
	protected $small;
	protected $seller;
	protected $index;

	public function _initialize()
	{
		$this->goods = new Goods();
		$this->small = new Small();
		$this->seller = new Seller();
		$this->index = new Index();
	}

	/*驱动商家添加商品的页面*/
	public function addGoods()
	{		
		if(empty(Session::get('id')))
		{
			$this->index->index();
			die;
		}
		$small = $this->small->addCategory('name' , '');	
		$this->assign('small' , $small);
		return $this->fetch();
	}

	/*编辑商品*/
	public function editGoods()
	{
		$data = $this->request->param('id');
		$res = $this->goods->getGoods('id' , $data)[0];

		$res['edit'] = 1;
		$this->assign('small',$res);
		return $this->fetch('addgoods/addgoods');
		/*return $this->fetch('addgoods/editgoods');*/
	}

	/*更新商品信息*/
	public function updateInfo()
	{

		$data = $this->request->post();
		$res = $this->goods->updateGoods($data);	
		if($res)
		{
			return 1;
		}
		return null;
	}

	/*添加商品的详细信息*/
	public function addInfo()
	{	
		if(empty(Session::get('id')))
		{
			$this->index->index();
			die;
		}

		$number = Session::get('small');
		$res = $this->small->getByType('name' , $number)[0];
		if(!$res)
		{
			$this->addInfo();
			die;
		}

		$number = $res['big_id'] .'_' . $res['id'] . '_' . time();
		$numRes = $this->goods->getGoods('number' , $number);
		
		/*商家id登录时完善*/
		$info['seller_id'] = Session::get('id');

		/*先假设有id 待会处理session问题*/
		$info['big_id'] = $this->seller->getByType('id', $info['seller_id'])[0]['big_id'];;

		$info['small_id'] = $res['id'];
		$info['number'] = $number;
		$info['name'] = Session::get('name');
		$info['picture'] = Session::get('picture');
		$info['price'] = Session::get('price');
		$info['discount'] = Session::get('discount');
		$info['stock'] = Session::get('stock');

		$res = $this->goods->add($info);
		if(!$res)
		{
			$this->error('执行错误' , 'Addgoods/addGoods');
			die;
		}
		$this->success('执行成功!' ,  'Addgoods/showSellerGoods');	
	}

	/*驱动小店首页 得到展示所需数据*/
	public function showSellerGoods()
	{
		$info= [];
		$id = Session::get('id');
		if(empty($id))
		{
			$this->redirect( 'Seller/sellogin' , '账户未登录');
			die;
		}

		$groupRes = $this->goods->groupGoods($id); 
		if(!$groupRes)
		{
			die;
		} 

		foreach ($groupRes as $key => $value) 
		{
			$info[$key]['count'] = $value['count'];
			$info[$key]['small_id'] = $value['small_id']; 

			/*得到类型的标签名*/
			$lable = $this->small->getByType('id' , $value['small_id']);
			if(!$lable)
			{
				die;
			}
			$info[$key]['lable'] = $lable[0]['name'] ;
			$obj = $this->goods->selectGoods( 'small_id' , $value['small_id']);
			$info[$key]['obj'] = $obj;
		}

		/*用户名*/
		$seller_name = Session::get('name');
		
		$this->assign('seller_name' , $seller_name);
		$this->assign('info' , $info);
		return $this->fetch();	
	}

	/*驱动缺货统计页面*/
	public function stockGoods()
	{
		$key = 'seller_id';
		$value = Session::get('id');
		$res = $this->goods->getStockGoods($key , $value);

		foreach ($res as $key => $value) 
		{
			$data = $this->small->getByType('id' , $value['small_id'])[0]['name'];
			$res[$key]['small_id'] = $data ;
		}

		$count = $this->goods->getCount();
		$this->assign('count' , $count);
		$this->assign('res' , $res);
		return $this->fetch('addgoods/stockGoods');
	}

}

















