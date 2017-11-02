<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Collectgoods as CollectgoodsModel;
use think\Session;
use app\index\model\Goods;
class Collectgoods	extends Controller
{
	protected $collect;
	protected $goods;

	public function _initialize()
	{	
		$this->collect = new CollectgoodsModel();
		$this->goods = new Goods();
	}
	public function collectGoods()
	{	
		$res = $this->collect->where('user_id',Session::get('id'))->select();
		if($res){
			foreach ($res as $val) {
			$arr[]=$this->goods->collection($val['goods_id']);
			}
			//dump($arr);die;
		$numRes = $this->collect->count('id');
		//dump($numRes);die;
		//dump($arr);die;
		$this->assign('arr',$arr);
		$this->assign('numRes',$numRes);
		return $this->fetch();
		}else{
			return $this->fetch();
		}

		
	
	}

	public function addCollect()
	{
		$data = $this->request->param();
		if(empty(Session::get('id')))
		{
			$this->redirect('User/login');
			die;
		}
		$data['user_id'] = Session::get('id');
		$res = $this->collect->addCollect($data);
		return $res; 
	}

	
} 