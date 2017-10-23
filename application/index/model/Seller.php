<?php
namespace app\index\model;

use think\Model;

class Seller  extends Model
{

	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		return $this->id;
	}

}
















