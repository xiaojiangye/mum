<?php
namespace app\index\model;

use think\Model;

class Seller  extends Model
{

	/*添加信息*/
	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		return $this->id;
	}

	public function getByType($key , $value)
	{
		return $this->where($key , $value)->select();
	}

	public function selectSeller()
	{
		return $this->field('id,big_id,name,description,create_time')->select();
	}

}
















