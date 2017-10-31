<?php

namespace app\index\model;

use think\Model;
use think\Session;


class Collectgoods extends Model
{
	public function addCollect($data)
	{
		$res = $this->where($data)->find();
		if($res)
		{
			if($res['status'] == 0)
			{
				$this->where($data)->update(['status' => 1]);
				return 0;
			}
			else if($res['status'] == 1)
			{
				$this->where($data)->update(['status' => 0]);
				return 1;
			}
		}
		$this->data($data);
		$this->save();
		return $this->id;
	}


}














