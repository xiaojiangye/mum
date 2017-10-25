<?php

namespace app\index\model;

use think\Model;

class Goods extends Model
{
	public function add($info)
	{
		$this->data($info);
		$this->allowField(true)->save();
		return $this->id;
	}
}



















