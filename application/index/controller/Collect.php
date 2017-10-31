<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Collect as CollectModel;
class Collect extends Controller
{	
	protected $collect;
	public function collect()
	{	
		/*$good = input('param.');
		$data = ['user_id'=> session::get('id'),'goods_id'=>$good['good']];
		$res = $this->car->where($data)->setInc('number',1);
		 if (!$res) {
		  	$this->car->data(['goods_id'=>$good['good'],'user_id'=>session::get('id')]);
			$res = $this->car->save();
		  }
		if ($res) {
			$this->success('收藏成功','index/branlist');
		}else {
			$this->error('收藏藏失败','index/branlist');
		}
*/
		return $this->fetch();
	}
}