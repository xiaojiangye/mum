<?php

namespace app\admin\model;

use think\Model;

class Carousel extends Model
{
	public function add($data)
	{
		$this->data($data);
		$this->allowField(true)->save();
		$data['id'] = $this->id;
		return $data;
	}


}






















