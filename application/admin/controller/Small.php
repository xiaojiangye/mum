<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Big;
use app\admin\model\Small as SmallModel;

class Small extends Controller
{
	protected $big;
	protected $small;

	public function _initialize()
	{
		$this->big = new Big();
		$this->small = new SmallModel();
	}

	/*驱动页面*/
	public function small()
	{
		$bigType = $this->big->selectBig();
		$this->assign('bigType' , $bigType);
		$this->assign('type' , 'small');

		$data = $this->small->selectSmall();
		/*把商品的对应的大版块id得到对应的style*/
		if($data)
		{
			foreach($data as $key =>  $val)
			{
				$bigId = $val['big_id'];
				$res = $this->big->getByField('id' , $bigId);
				if($res)
				{
					$data[$key]['big_style'] = $res[0]['style'];
				}
				else
				{
					$data[$key]['big_style'] = '空';
				}
			}
		}
		
		$this->assign('data' , $data);
		return $this->fetch('public/category_seller_add');
	}

	/*添加商品的具体类型*/
	public function addCategory()
	{
		$data = $this->request->post();
		$style = $data['sel'];
		$bigRes = $this->big->getByType($style);
		$data['big_id'] = $bigRes[0]['id'];
		$res = $this->small->add($data);
		if($res)
		{
			return json_encode($res);
		}else{
			return 0;
		}
	}

}
















