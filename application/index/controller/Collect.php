<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Collect as CollectModel;
class Collect extends Controller
{	

	protected $collect;
	public function _initialize()
	{
		$this->collect = new CollectModel();
	}
	public function collect()
	{	

		return $this->fetch();
	}
	//详情中收藏商品
	public function coll()
	{
		$good = input('param.');
		dump($good);die;
		dump(session::get('id'));die;
	}
	// 	$data = ['user_id'=> session::get('id'),'goods_id'=>$good['good']];
	// 	$res = $this->collect->where($data)->setInc('number',1);
	// 	dump($res);die;
	// 	 if (!$res) {
	// 	  	$this->collect->data(['goods_id'=>$good['good'],'user_id'=>session::get('id')]);
	// 		$res = $this->collect->save();
	// 	  }
	// 	if ($res) {
	// 		$this->success('收藏成功','index/branlist');
	// 	}else {
	// 		$this->error('收藏藏失败','index/branlist');
	// 	}
	// }
}