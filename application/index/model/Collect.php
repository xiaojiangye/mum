<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Collect extends Model
{
	public function collect($good)
	{
		return $this->where('goods_id',$good['good'])->select();
	}
}

